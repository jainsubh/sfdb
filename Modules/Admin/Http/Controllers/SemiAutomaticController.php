<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Tasks;
use App\Alert;
use App\SemiAutomatic;
use App\SemiAutomaticGallery;
use App\Authorizable;
use PDF;
use App\Dataset;

class SemiAutomaticController extends Controller
{
    use Authorizable;
    public $datasets;

    public function __construct(){
        $this->datasets = Dataset::latest()->get();
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(){
        return view('admin::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create($task_id){
        $datasets = $this->datasets;
        $task = Tasks::own()->with(['semi_automatic', 'latest_task_log.assigned_to_user', 'latest_task_log.assigned_by_user'])
            ->latest('tasks.created_at')
            ->where('id', $task_id)
            ->first();

        if(!isset($task)){
            return redirect()->back()
                        ->withErrors('Not Valid Task')
                        ->withInput();
        }
        
        return view('admin::semi_automatic.create', compact(['task', 'datasets']));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request['report_by'] = auth()->user()->id;
        if($request['semi_automatic_id']){
            $semiModel = SemiAutomatic::with('gallery')->findOrFail($request['semi_automatic_id']);
            $semiModel->fill(
                $request->all()
            );
            //update task udpated_at date and alert title
            $update = $semiModel->tasks()->update(['updated_at' => now()]);
            $update_alert_title = $semiModel->alert()->update(['title' => $request['title']]);

            $semi_data = $semiModel->save();
            
        }else{
            //Generate INSR number for Institutional Report
            $randomid = mt_rand(100000,999999); 
            $current_date_time = Carbon::now('UTC')->timestamp;
            
            $reportfilename = 'SAR-'.$randomid.'-'.$current_date_time;

            $request['ref_id'] = $reportfilename;
            $semi_data = SemiAutomatic::create($request->all());
        }
            
        
        if($semi_data){
            return response()->json([
                'status' => 'success',
                'message' => 'Report data save successfully',
                'data' => $semi_data
            ], 200);
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to save data'
            ], 500);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $datasets = $this->datasets;
        $task = Tasks::own()->with(['semi_automatic','semi_automatic.gallery','alert.sectors', 'alert.keywords', 'alert.links', 'latest_task_log.assigned_to_user', 'latest_task_log.assigned_by_user'])
            ->latest('tasks.created_at')
            ->where('id', $id)
            ->first();
        $keywords  = $task->alert->keywords->pluck('keyword')->toArray();
        $links  = $task->alert->links->pluck('url')->toArray();

        return view('report_template.semi_automatic', compact(['task', 'keywords','links', 'datasets']));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('admin::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $semi_automatic_report = SemiAutomatic::inProgress()->findOrFail($id);
        if($request->hasFile('file')){
            $validator = Validator::make($request->all(), [
                'file' => 'required|image|mimes:jpeg,png,jpg',
            ]);
            
            if ($validator->fails()){
                return response()->json($validator->errors()->first(), 302);
            }

            $image      = $request->file;
            $fileName   = time().'_'.$image->getClientOriginalName();
            if($image->storeAs('semi-automatic/photos', $fileName)){
                $semi_automatic_report->gallery()->save(new SemiAutomaticGallery(['images' => $fileName]));
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Images added successfully',
                'data' => $semi_automatic_report->gallery->last()
            ], 200);
        }else{
            if($semi_automatic_report->update($request->all())){
                return response()->json([
                    'status' => 'success',
                    'message' => 'Report data save successfully',
                    'data' => $semi_automatic_report
                ], 200);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function complete(Request $request, $id)
    {

        
        $task = Tasks::own()->with(['semi_automatic','semi_automatic.gallery','alert.sectors', 'alert.keywords', 'alert.links', 'latest_task_log.assigned_to_user', 'latest_task_log.assigned_by_user'])
            ->latest('tasks.created_at')
            ->where('id', $id)
            ->first();
        $keywords  = $task->alert->keywords->pluck('keyword')->toArray();
        $links  = $task->alert->links->pluck('url')->toArray();
        $semiModel = SemiAutomatic::findOrFail($task->semi_automatic->id);

        $pdf = PDF::loadHTML(view('report_template.semi_automatic', compact(['task', 'keywords','links'])));
        $pdf->save(storage_path('app/semi-automatic/'.$semiModel->ref_id.'.pdf'), $overwrite = true);

        $semiModel->status = 'complete';
        if($semiModel->save()){
            flash('Report completed successfully')->success();
            return redirect()->route('tasks.index');    
        }else {
            return redirect()->back()
                        ->withErrors(['Failed to complete report'])
                        ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function download($filename, $filetype = 'pdf')
    {
        $filepath = 'semi-automatic/'.$filename.'.'.$filetype;
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
    
    /**
     * unarchive
     *
     * @param  mixed $id
     * @return void
     */
    public function unarchive($id)
    {
        $semi_automatic_report = SemiAutomatic::where('id', $id)->firstOrFail();
        if($semi_automatic_report->archive == 0){
            return response()->json([
                'status'=>'Error',
                'message' => 'Report already unarchived'
            ], 409);
        }else{
            $semi_automatic_report->archive = 0;
            if($semi_automatic_report->save()){
                return response()->json([
                    'status'=>'Success',
                    'message' => 'Semi automatic report unarchived successfully'
                ], 200);
            }else{
                return response()->json([
                    'status'=>'Error',
                    'message' => 'Error - while unarchiving semi automatic report'
                ], 500);
            }
        }
    } 
    
    /**
     * bulk_archive
     *
     * @param  mixed $request
     * @return void
     */
    public function bulk_archive(Request $request)
    {
        parse_str($request->input('data'), $request);
        $ref_id = $request['semi_automatic_report'];
        $semi_automatic_report = SemiAutomatic::whereIn('ref_id', $ref_id);
        
        if($semi_automatic_report->update(['archive' => 1])) {
            return response()->json([
                'status'=>'Success',
                'message' => 'Report archived successfully',
                'data' => $semi_automatic_report
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
    public function bulk_delete(Request $request)
    {
        parse_str($request->input('data'), $request);
        $ref_id = $request['semi_automatic_report'];
        $semi_automatic_report = SemiAutomatic::whereIn('ref_id', $ref_id);
        
        if($semi_automatic_report->delete()) {
            return response()->json([
                'status'=>'Success',
                'message' => 'Report deleted successfully',
                'data' => $semi_automatic_report
            ], 200);
        }
        else{
            return response()->json('Error - while deleting report',302);
        }
    }
    
    /**
     * regenerate
     *
     * @param  mixed $id
     * @return void
     */
    public function regenerate($id){
        $semi_automatic_report = SemiAutomatic::where('id', $id)->firstOrFail();
        if($semi_automatic_report->status == 'progress'){
            return response()->json([
                'status'=>'Error',
                'message' => "Report can't be continued, already in pending status"
            ], 409);
        }else{
            $semi_automatic_report->status = 'progress';
            if($semi_automatic_report->save()){
                return response()->json([
                    'status'=>'Success',
                    'message' => 'Report reopened successfully',
                    'id' => $semi_automatic_report->task_id
                ], 200);
            }else{
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
            if($image->storeAs('semi-automatic/photos', $fileName)){
                return response()->json(['file_name' => $fileName]);
            }
        }
    }
}
