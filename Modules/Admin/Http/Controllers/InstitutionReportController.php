<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Datatables;
use App\Authorizable;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Spatie\PdfToText\Pdf;
use Config;
Use App\InstitutionReport;
Use App\OrganizationUrl;
Use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
Use DB;
use App\Dataset;

class InstitutionReportController extends Controller
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
    public function index()
    {
        $datasets = $this->datasets;
        return view('admin::institution_report.index', compact('datasets'));
    }

    /**
     * Return datatable format json for user listing
     * @return json
     */
    public function datatable(Request $request)
    {   
        if ($request->ajax()) {
            //DB::enableQueryLog(); // Enable query log
            $institute_report = InstitutionReport::active()->with('organization:id,name')->orderBy('date_time','desc');
            //dd(DB::getQueryLog()); // Show results of log
            return Datatables::of($institute_report)
            ->addColumn('institute_name', function ($institute_report) {
                return $institute_report->organization()->pluck('name')->toArray();
            })->rawColumns(['institute_name'])
            ->editColumn('date_time', function ($institute_report) {
                return Carbon::parse($institute_report->date_time, 'UTC')->setTimezone(auth()->user()->timezone);
            })
            ->editColumn('institution_report', function ($institute_report) {
                return ['name' => $institute_report->institution_report, 'download_pdf' => route('institution_report.download', [$institute_report->institution_report, 'pdf']), 'download_txt' => route('institution_report.download', [$institute_report->institution_report, 'txt']), 'send_library' => $institute_report->send_library];
            })->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $organisation_name = OrganizationUrl::all()->map(function ($item) {
            return ['value' => $item['id'], 'label' => $item['name']];
        })->toArray();
        $organisation_name = json_encode($organisation_name);
        return view('admin::institution_report.create', compact('organisation_name'))->render();
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:120',
            'institute_id' => 'required|integer',
            'date_time' => 'required',
            'institution_report' => 'required|mimes:pdf|max:51200|clamav'
        ]);
        $institute_report = [];
        if (!$validator->fails()) {

            //Generate INSR number for Institutional Report
            $randomid = mt_rand(100000,999999); 
            $current_date_time = Carbon::now('UTC')->timestamp;
            
            $reportfilename = 'INSR-'.$randomid.'-'.$current_date_time;
            
            $institute_report['name'] = $request->name;
            $institute_report['institute_id'] = $request->institute_id;

            $dateTime = Carbon::parse($request->date_time, auth()->user()->timezone)->setTimezone('UTC');

            $institute_report['date_time'] = $dateTime;
            $institute_report['institution_report'] = $reportfilename;
            
            //uploading file to directory
            Storage::putFileAs('institution_report', $request->file('institution_report'), $reportfilename.'.pdf', 'private');
            $pdf_path = storage_path('app/institution_report/'.$reportfilename.'.pdf');
            $text = Pdf::getText($pdf_path, Config::get('constants.pdftotext.lib_path'));
            Storage::put('institution_report/'.$reportfilename.'.txt', $text);

            if(InstitutionReport::create($institute_report)){
                flash('Successfully created institution report.')->success();
            }
            else{
                flash('Failed to create institution report.')->error();
            }
        }else{
            flash('Failed to create institution report.')->error();
            return redirect()->back()
            ->withErrors($validator)
            ->withInput($request->input());
        }
        return redirect()->route('institution_report.index');
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
                $institute_report = InstitutionReport::active()-> with(['organization:id,name', 'tasks.fully_manual', 'tasks.product'])->where('id', $id)->firstOrFail();
                $analysts = User::role(['Analyst', 'Supervisor'])->pluck('name','id')->toArray(); 
                return view('institution_reports.show',compact(['institute_report', 'analysts']))->render();
            }
            catch(ModelNotFoundException $e)
            {
                return response()->json('Institution Report for this task has been deleted',302);
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
        $institution_report = InstitutionReport::with('organization:id,name')->where('id', $id)->first();
        $institution_report->institution_name = $institution_report->organization()->pluck('name', 'id')->toArray();
        $organisation_name = OrganizationUrl::all()->map(function ($item) {
            return ['value' => $item['id'], 'label' => $item['name']];
        })->toArray();
        $organisation_name = json_encode($organisation_name);
        $institution_report->date_time =  Carbon::parse($institution_report->date_time, 'UTC')->setTimezone(auth()->user()->timezone);
        return view('admin::institution_report.edit', compact('institution_report', 'organisation_name'))->render();
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $institutional_report = $request->file('institution_report');
        $date_time =  Carbon::parse($request->date_time, auth()->user()->timezone)->setTimezone('UTC');

        $fileModel = InstitutionReport::findOrFail($id);

        if($institutional_report != ''){
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:120',
                'institute_id' => 'required|integer',
                'date_time' => 'required',
                'institution_report' => 'required|mimes:pdf|max:51200'
            ]);

            if (!$validator->fails()) {

                //Generate INSR number for Institutional Report
                $randomid = mt_rand(100000,999999); 
                $current_date_time = Carbon::now('UTC')->timestamp;
                $reportfilename = 'INSR-'.$randomid.'-'.$current_date_time;
                
                

                $fileModel->fill(array(
                    'name' => $request->name, 
                    'date_time' => $date_time,
                    'institute_id' => $request->institute_id,
                    'institution_report' => $reportfilename,
                ));
    
                Storage::putFileAs('institution_report', $request->file('institution_report'), $reportfilename.'.pdf', 'private');
                
                $pdf_path = storage_path('app/institution_report/'.$reportfilename.'.pdf');
                $text = Pdf::getText($pdf_path, Config::get('constants.pdftotext.lib_path'));
                Storage::put('institution_report/'.$reportfilename.'.txt', $text);

                if($fileModel->save()){
                    flash('Successfully updated institution report.')->success();
                }else{
                    flash('Failed to update institution report.')->error();
                }
            }else{
                flash('Failed to update institution report.')->error();
                return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
            }
        }else{
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:120',
                'institute_id' => 'required|integer',
                'date_time' => 'required',
            ]);

            if (!$validator->fails()) {

                $fileModel->fill(array(
                    'name' => $request->name, 
                    'date_time' => $date_time,
                    'institute_id' => $request->institute_id,
                ));
                
                if($fileModel->save()){
                    flash('Successfully updated institution report.')->success();
                }else{
                    flash('Failed to update institution report.')->error();
                }
            }else{
                flash('Failed to update institution report.')->error();
                return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
            }
        }

        return redirect()->route('institution_report.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $ids = explode(",",$id);
        $flag = true;
        if(count($ids) > 1){
            $institution_reports = InstitutionReport::with(['tasks'])->whereIn('id',$ids)->get();
        }
        else{
            $institution_reports = InstitutionReport::with(['tasks'])->findorFail($ids);
        }
        
        foreach($institution_reports as $institution_report){
            if($institution_report->tasks != null)
                $flag = false;
        }

        if($flag == true){
            if( $institution_report->delete()) {
                return 'success';
            } else {
                return 'error';
            }
        }
        else{
            return response()->json('Institution Report with a task linked to it cannot be deleted', 302);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function download($filename, $filetype = 'pdf')
    {
        $filepath = 'institution_report/'.$filename.'.'.$filetype;
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
     * Move report to library
     * @param int $id
     * @return Renderable
     */
    public function move_to_library($id)
    {   
        $ids = explode(",",$id);
        if(count($ids) > 1){
            $inst_report = InstitutionReport::whereIn('id', $ids);
        }else{
            $inst_report = InstitutionReport::where('id', $ids);
        }

        $institution_report = $inst_report->get();
        if($inst_report->update(['send_library' => 1])){
            return response()->json([
                'status'=>'Success',
                'message' => 'Report moved to library successfully',
                'data' => $institution_report
            ], 200);
        }else{
            return response()->json([
                'status'=>'Error',
                'message' => 'Error - while moving report to library',
                'data' => $institution_report
            ], 500);
        }
    }

    /**
     * Move report to library
     * @param int $id
     * @return Renderable
     */
    public function archive($id)
    {
        $ids = explode(",",$id);
        if(count($ids) > 1){
            $inst_report = InstitutionReport::whereIn('id', $ids);
        }else{
            $inst_report = InstitutionReport::where('id', $ids);
        }    
        $institution_report = $inst_report->get();
        
        if($inst_report->update(['archive' => 1])){
            return response()->json([
                'status'=>'Success',
                'message' => 'Report archived successfully',
                'data' => $institution_report
            ], 200);
        }else{
            return response()->json('Error - while archiving report',302);
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
        $ref_id = $request['institution_report'];
        $institution_report = InstitutionReport::whereIn('institution_report', $ref_id);
        
        if($institution_report->update(['archive' => 1])) {
            return response()->json([
                'status'=>'Success',
                'message' => 'Report archived successfully',
                'data' => $institution_report
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
        $flag = true;
        $ref_id = $request['institution_report'];

        $institution_reports = InstitutionReport::with(['tasks'])->whereIn('institution_report', $ref_id)->get();

        foreach($institution_reports as $institution_report){
            if($institution_report->tasks != null)
                $flag = false;
        }

        if($flag == true){
            if($institution_report->delete()) {
                return response()->json([
                    'status'=>'Success',
                    'message' => 'Report deleted successfully',
                    'data' => $institution_report
                ], 200);
            }
            else{
                return response()->json('Error - while deleting report',302);
            }
        }
        else{
            return response()->json('Institution Report with a task linked to it cannot be deleted', 302);
        }
    }
    
    /**
     * archive
     *
     * @param  mixed $id
     * @return void
     */
    public function unarchive($id){
        
        $institution_report = InstitutionReport::where('id', $id)->firstOrFail();
        if($institution_report->archive == 0){
            return response()->json([
                'status'=>'Error',
                'message' => 'Report already unarchived'
            ], 409);
        }else{
            $institution_report->archive = 0;
            if($institution_report->save()){
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
     * institution_report_ajax
     *
     * @return void
     */
    public function latest_institution_report(Request $request){
        
        $institution_report = InstitutionReport::doesnthave('tasks')->active()->where('id','>',$request['id'])->latest('id')->get();
        $latest_id = $institution_report->pluck('id')->first();
        return response()->json(['success' => true ,'html' => view('institution_reports.institutional_report_card', compact('institution_report'))->render(), 'latest_id'=>$latest_id]);
        
    }

    /**
     * institution_report_ajax
     *
     * @return void
     */
    public function paginate_institution_report(Request $request){
        
        $institution_report = InstitutionReport::doesnthave('tasks')->active()->latest('id')->paginate(6);
        $institution_report->withPath(route('institution_report.paginate_institution_report'));
        $with_pagination = 1;
        return view('institution_reports.institutional_report_card', compact('institution_report', 'with_pagination'))->render();
        
    }
}
