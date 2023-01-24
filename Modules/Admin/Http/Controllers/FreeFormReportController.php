<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException as ModelNotFoundException;
use Carbon\Carbon;
use App\FreeFormReport;
Use App\Sectors;
use App\User;
use App\Tasks;
use App\Country;
use Mail;
use Spatie\Activitylog\Models\Activity;
use App\Tasklog;
use Illuminate\Support\Facades\Storage;
use PDF;
use App\Mail\DataSent;
use App\Dataset;
use App\DatasetData;
use App\ReportCountry;

class FreeFormReportController extends Controller
{

    public $datasets;

    public function __construct(){
        $this->datasets = Dataset::latest()->get();
    }

    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $datasets = $this->datasets;
        return view('admin::freeform_report.index', compact('datasets'));
    }
    
    /**
     * datatable
     *
     * @return void
     */
    public function datatable()
    {   
        if(auth()->user()->hasRole('Analyst')){
            $freeform_report = FreeFormReport::with(['tasks'])->own()->active()->latest()->get();
        }else{
            $freeform_report = FreeFormReport::with(['tasks'])->active()->latest()->get();
        }
        return Datatables::of($freeform_report) 
        ->addColumn('sector_id', function ($freeform_report) {
            return $freeform_report->sectors()->pluck('name')->toArray();
        })->rawColumns(['sector_id'])
        ->addColumn('assigned', function ($freeform_report) {
            return $freeform_report->users()->pluck('name')->toArray();
        })->rawColumns(['assigned'])
        ->addColumn('priority', function ($freeform_report) {
            return ucfirst($freeform_report->priority);
        })->rawColumns(['priority'])
        ->editColumn('date_time', function ($freeform_report) {
            return Carbon::parse($freeform_report->date_time, 'UTC')->setTimezone(auth()->user()->timezone);
        })
        ->editColumn('freeform_report', function ($freeform_report) {
            return ['name' => $freeform_report->ref_id, 'send_library' => $freeform_report->send_library, 'status' => $freeform_report->status, 'download_pdf' => route('freeform_report.download', [$freeform_report->ref_id, 'pdf'])];
        })
        ->editColumn('created_at', function ($freeform_report) {
            return Carbon::parse($freeform_report->created_at, 'UTC')->setTimezone(auth()->user()->timezone);
        })->editColumn('updated_at', function ($freeform_report) {
            return Carbon::parse($freeform_report->updated_at, 'UTC')->setTimezone(auth()->user()->timezone);
        })->editColumn('completed_at', function ($freeform_report) {
            if($freeform_report->tasks->completed_at != null)
            return Carbon::parse($freeform_report->tasks->completed_at, 'UTC')->setTimezone(auth()->user()->timezone);
            else 
            return '--';
        })->make(true);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $datasets = $this->datasets;

        $dataset = Dataset::with(['data'])->get();
        $data_arr = new Dataset;
        $dataset_arr = $data_arr->datasetWithData($dataset);

        $countries = Country::orderBy('country_name')->pluck("country_name", "id")->unique();
        
        $sectors = Sectors::all()->pluck("name", "id");
        
        $assigned = User::with('roles')->role(['Analyst', 'Supervisor'])->pluck("name", "id");
        
        return view('admin::freeform_report.create')->with(compact('sectors','assigned', 'datasets', 'dataset_arr', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request){
        
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:240',
            'objective' => 'max:240',
            'priority' => 'required',
            'assigned' => 'required',
            'datetime' => 'required',
            'thumbnail_report' => 'required|image|mimes:jpeg,png,jpg',
        ]);

        if ($validator->fails()){

            return redirect()->back()
            ->withErrors($validator)
            ->withInput();

        }else{
            $image      = $request->thumbnail_report;
            $fileName   = time().'.'.$image->getClientOriginalExtension();
            
            $image->storeAs('freeform_report/thumbnail', $fileName);

            $request['thumbnail'] = $fileName;

            //generate ref_id
            $randomid = mt_rand(100000,999999); 
            $current_date_time = Carbon::now('UTC')->timestamp;
            $reportfilename = 'FFM-'.$randomid.'-'.$current_date_time;
            $request['ref_id'] = $reportfilename;

            //datetime
            $dateTime = Carbon::parse($request->date_time, auth()->user()->timezone)->setTimezone('UTC');
            $request['date_time'] = $dateTime;
            if($freeform_data = FreeFormReport::create($request->all())){
                
                $dataset_data = [];

                $datasets = $request->dataset;
                if(is_array($datasets) && count($datasets) > 0){
                    foreach($datasets as $dataset => $data_arr){
                        foreach($data_arr as $key => $data){
                            $data = ['dataset_id' => $dataset, 'data_id' => $data];
                            $dataset_data[] = $data;
                        }
                    }
                }

                $freeform_data->data()->attach($dataset_data);

                $task = [
                    'priority' => $request['priority'],
                    'status' => 'new',
                    'due_date' => date($dateTime),
                ];

                $task = $freeform_data->tasks()->create($task);
                
                if($task){
                    $task_log = [
                        'description' => 'created',
                        'task_id' => $task->id,
                        'assigned_to' => $freeform_data->assigned,
                        'assigned_by' => auth()->user()->id
                    ];
                    
                    if($freeform_data->assigned == auth()->user()->id){
                        $log = 'self_assign';
                    }else{
                        $log = 'assign';
                    }
                    $userModel = User::findOrFail(auth()->user()->id);

                    $assignedUser = User::where('id', $freeform_data->assigned)->firstOrFail();

                    activity('tasks_log')
                    ->causedBy($userModel)
                    ->performedOn($task)
                    ->withProperties(['assigned_to' => $assignedUser->id, 'assigned_to_name' => $assignedUser->name])
                    ->log($log);

                    if(Tasklog::Create($task_log)){
                        $task = Tasks::with(['subject', 'latest_task_log.assigned_to_user', 'latest_task_log.assigned_by_user'])->findOrFail($task->id);
                        /*Mail::send('tasks.assign_email_temp', compact('task'), function($message) use ($task) {
                            $message->to($task->latest_task_log->assigned_to_user->email, $task->latest_task_log->assigned_to_user->name)
                                    ->subject('Task Assigned');
                            $message->from($task->latest_task_log->assigned_by_user->email, $task->latest_task_log->assigned_by_user->name);
                         });*/

                         $data = array(
                            'from_email' => $task->latest_task_log->assigned_by_user->email,
                            'from_name' => $task->latest_task_log->assigned_by_user->name,
                            'subject' => 'Task Assigned',
                            'view' => 'tasks.assign_email_temp',
                            'data' => $task,
                            'timezone' => auth()->user()->timezone,
                            'auth_name' => auth()->user()->name
                        );

                        $associateCountries = [];
                        if(count($request->countries) > 0)
                        foreach($request->countries as $key => $country){
                            $associateCountries[] = new ReportCountry(['country_id' => $country]);
                        }
                        $freeform_data->report_countries()->saveMany($associateCountries);
            
                        Mail::to($task->latest_task_log->assigned_to_user->email, $task->latest_task_log->assigned_to_user->name)->queue(new DataSent($data));

                    }
                }else{
                    return response()->json('Failed to create task', 302);
                }

                flash('Free Form Report created successfully.')->success();
            }
            else{
                flash('Failed to create freeform report.')->error();
            }
        }

        if(auth()->user()->hasRole('Analyst')){
            return redirect()->route('freeform_report.report_create', $freeform_data->id);
        }else{
            return redirect()->route('freeform_report.index');
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id, Request $request)
    {
        if($request->ajax()){
            try
            {
                $freeform_report = FreeFormReport::active()->where('id', $id)->firstOrFail();
                $analysts = User::role(['Analyst', 'Supervisor'])->pluck('name','id')->toArray(); 
                return view('freeform_report.show',compact(['freeform_report', 'analysts']))->render();
            }
            catch(ModelNotFoundException $e)
            {
                return response()->json('FreeForm Report for this task has been deleted',302);
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $datasets = $this->datasets;

        $dataset = Dataset::with(['data'])->get();
        $data_arr = new Dataset;
        $dataset_arr = $data_arr->datasetWithData($dataset);

        $sectors = Sectors::all()->pluck("name", "id");
        $countries = Country::orderBy('country_name')->pluck("country_name", "id")->unique();
        $assigned = User::with('roles')->role(['Manager', 'Analyst'])->pluck("name", "id");
        $freeform_report = FreeFormReport::with(['data', 'report_countries:subject_id,country_id'])->findOrFail($id);

        $dataset_lookup = $freeform_report->data->mapToGroups(function ($data, $key) {
            return [$data->dataset_id => $data->pivot->data_id];
        });

        $dataset_lookup = $dataset_lookup->toArray();

        $country_lookup = $freeform_report->report_countries->map(function ($data, $key) {
            return $data->country_id;
        });

        return view('admin::freeform_report.edit')->with(compact('sectors','assigned','freeform_report', 'datasets', 'dataset_arr', 'dataset_lookup', 'country_lookup', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //dd($request->all());
        $thumbnail_report = $request->file('thumbnail_report');
        //dd($thumbnail_report);
        if($thumbnail_report != ''){
            $validator = Validator::make($request->all(), [
                'title' => 'max:90',
                'objective' => 'max:60',
                'thumbnail_report' => 'required|image|mimes:jpeg,png,jpg',
            ]); 
        }else{
            $validator = Validator::make($request->all(), [
                'title' => 'max:90',
                'objective' => 'max:60',
            ]);
        }

        if ($validator->fails()){

            return redirect()->back()
            ->withErrors($validator)
            ->withInput();

        }else{
            $freeFormModel = FreeFormReport::findOrFail($id);
            
            if(is_array($request->dataset)){
                $dataset_data = [];

                $datasets = $request->dataset;

                if(is_array($datasets) && count($datasets) > 0){
                    foreach($datasets as $dataset => $data_arr){
                        foreach($data_arr as $key => $data){
                            $data = ['dataset_id' => $dataset, 'data_id' => $data];
                            $dataset_data[] = $data;
                        }
                    }
                }

                $freeFormModel->data()->sync($dataset_data);
            }

            if($thumbnail_report != ''){
                //dd($thumbnail_report);
                $image      = $request->thumbnail_report;
                
                $fileName   = time().'.'.$image->getClientOriginalExtension();
                //dd($fileName);
                $image->storeAs('freeform_report/thumbnail', $fileName);

                $request['thumbnail'] = $fileName;
            }

            if($request->ajax()) {
                if($freeFormModel->update($request->all())){
                    if(isset($request->countries)){
                        $associateCountries = [];
                        if(count($request->countries) > 0)
                            foreach($request->countries as $key => $country){
                                $associateCountries[] = new ReportCountry(['country_id' => $country]);
                            }
                        $freeFormModel->report_countries()->saveMany($associateCountries);
                    }
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Report data save successfully',
                        'data' => $freeFormModel
                    ], 200);
                }
            }else{
                if($freeFormModel->update($request->all())){
                    flash('Free Form Report updated successfully.')->success();
                }
                else{
                    flash('Failed to update freeform report.')->error();
                }
            }
        }
        if($request->ajax()) {
            return false;
        }else{
            return redirect()->route('freeform_report.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id){
        $ids = explode(",",$id);

        if(count($ids) > 1){
            $freeform_report = FreeFormReport::whereIn('id',$ids);
        }else{
            $freeform_report = FreeFormReport::where('id',$ids);
        }
        if( $freeform_report->delete() ){
            return 'success';
        }else{ 
            return 'error';
        }
    }
    
    /**
     * archive
     *
     * @param  mixed $id
     * @return void
     */
    public function archive($id){
        $ids = explode(",",$id);
        if(count($ids) > 1){
            $ff_report = FreeFormReport::whereIn('id', $ids);
        }else{
            $ff_report = FreeFormReport::where('id', $ids);
        }    
        $freeform_report = $ff_report->get();
        
        if($ff_report->update(['archive' => 1])){
            return response()->json([
                'status'=>'Success',
                'message' => 'Report archived successfully',
                'data' => $freeform_report
            ], 200);
        }else{
            return response()->json('Error - while archiving report',302);
        }
    }
    
    /**
     * move_to_library
     *
     * @param  mixed $id
     * @return void
     */
    public function move_to_library($id){
        $ids = explode(",",$id);
        if(count($ids) > 1){
            $ff_report = FreeFormReport::whereIn('id', $ids);
        }else{
            $ff_report = FreeFormReport::where('id', $ids);
        }    
        $freeform_report = $ff_report->get();
        if($ff_report->update(['send_library' => 1])){
            return response()->json([
                'status'=>'Success',
                'message' => 'Report moved to library successfully',
                'data' => $freeform_report
            ], 200);
        }else{
            return response()->json([
                'status'=>'Error',
                'message' => 'Error - while moving report to library',
                'data' => $freeform_report
            ], 500);
        }
    }

    /**
     * bulk_archive
     *
     * @param  mixed $id
     * @return void
    */
    public function bulk_archive(Request $request){

        parse_str($request->input('data'), $request);
        $ref_id = $request['freeform_report'];
        $freeform_report = FreeFormReport::whereIn('ref_id', $ref_id);
        
        if($freeform_report->update(['archive' => 1])) {
            return response()->json([
                'status'=>'Success',
                'message' => 'Report archived successfully',
                'data' => $freeform_report
            ], 200);
        }
        else{
            return response()->json('Error - while archiving report',302);
        }
    }

    /**
     * bulk_delete
     *
     * @param  mixed $request
     * @return void
     */
    public function bulk_delete(Request $request){

        parse_str($request->input('data'), $request);
        $ref_id = $request['freeform_report'];
        $freeform_report = FreeFormReport::whereIn('ref_id', $ref_id);
        
        if($freeform_report->delete()) {
            return response()->json([
                'status'=>'Success',
                'message' => 'Report deleted successfully',
                'data' => $freeform_report
            ], 200);
        }
        else{
            return response()->json('Error - while deleting report',302);
        } 
    }
    
    /**
     * archive
     *
     * @param  mixed $id
     * @return void
     */
    public function unarchive($id){
        
        $freeform_report = FreeFormReport::where('id', $id)->firstOrFail();
        if($freeform_report->archive == 0){
            return response()->json([
                'status'=>'Error',
                'message' => 'Report already unarchived'
            ], 409);
        }else{
            $freeform_report->archive = 0;
            if($freeform_report->save()){
                return response()->json([
                    'status'=>'Success',
                    'message' => 'Report unarchived successfully'
                ], 200);
            }else{
                return response()->json('Error - while unarchiving report',302);
            }
        }
    }
    
    /**
     * download
     *
     * @param  mixed $filename
     * @param  mixed $filetype
     * @return void
     */
    public function download($filename, $filetype = 'pdf')
    {
        $filepath = 'freeform_report/'.$filename.'.'.$filetype;
        $exists = Storage::disk('local')->exists($filepath); 
        if(!$exists)
        {
            flash('File does not exist')->error();
            return redirect()->back();
        }
        else{
            return Storage::disk('local')->download($filepath);   
        }
    }

    public function view_document($filename, $filetype = 'pdf')
    {
        $filepath = 'freeform_report/'.$filename.'.'.$filetype;
        $exists = Storage::disk('local')->exists($filepath); 
        if(!$exists)
        {
            flash('File does not exist')->error();
            return redirect()->back();
        }
        else{
            $headers = [
                'Content-Type' => 'application/pdf'
            ];
            $file = storage_path('app/'.$filepath);
            return response()->file($file);
        }
    }

    public function report_create($id){
        $datasets = $this->datasets;

        $dataset = Dataset::with(['data'])->get();
        $data_arr = new Dataset;
        $dataset_arr = $data_arr->datasetWithData($dataset);
        $countries = Country::orderBy('country_name')->pluck("country_name", "id")->unique();

        $freeform_report = FreeFormReport::with(['data', 'report_countries:subject_id,country_id'])->findOrFail($id);

        $dataset_lookup = $freeform_report->data->mapToGroups(function ($data, $key) {
            return [$data->dataset_id => $data->pivot->data_id];
        });

        $dataset_lookup = $dataset_lookup->toArray();

        $country_lookup = $freeform_report->report_countries->map(function ($data, $key) {
            return $data->country_id;
        });

        return view('admin::freeform_report.report_create', compact(['freeform_report', 'datasets', 'dataset_arr', 'dataset_lookup', 'countries', 'country_lookup']));
    }

    public function report_preview($id){
        $datasets = $this->datasets;
        $freeform_report = FreeFormReport::with('sectors')->findOrFail($id);
        return view('report_template.freeform_report', compact(['freeform_report', 'datasets']));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function complete(Request $request, $id){
        $freeform_report = FreeFormReport::with('sectors')->findOrFail($id);
        
        $pdf = PDF::loadHTML(view('report_template.freeform_report', compact(['freeform_report'])));
        $pdf->save(storage_path('app/freeform_report/'.$freeform_report->ref_id.'.pdf'), $overwrite = true);
        
        $freeform_report->status = 'complete';
        $freeform_report->send_library = '1';
        
        if($freeform_report->save()){
            flash('Report completed successfully')->success();
            return redirect()->route('tasks.index');    
        }else {
            return redirect()->back()
                        ->withErrors(['Failed to complete report'])
                        ->withInput();
        }
    }
    
    /**
     * regenerate
     *
     * @param  mixed $id
     * @return void
     */
    public function regenerate($id){
        $freeform_report = FreeFormReport::where('id', $id)->firstOrFail();
        if($freeform_report->status == 'progress'){
            return response()->json([
                'status'=>'Error',
                'message' => "Report can't be continued, already in pending status"
            ], 409);
        }else{
            $freeform_report->status = 'progress';
            if($freeform_report->save()){
                return response()->json([
                    'status'=>'Success',
                    'message' => 'Report reopened successfully',
                    'id' => $freeform_report->id
                ], 200);
            }
            else{
                return response()->json('Error - while continuing report',302);
            }
        }
    }

    public function fileUpload(Request $request) {
        if($request->hasFile('file')){
            $validator = Validator::make($request->all(), [
                'file' => 'required|image|mimes:jpeg,png,jpg',
            ]);
            
            if ($validator->fails()){
                return response()->json($validator->errors()->first(), 302);
            }
            $image      = $request->file;
            $fileName   = time().'_'.$image->getClientOriginalName();
            if($image->storeAs('freeform_report/photos', $fileName)){
                return response()->json(['file_name' => $fileName]);
            }
        }
    }
}
