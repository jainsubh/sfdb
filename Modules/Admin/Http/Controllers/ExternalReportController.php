<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Spatie\PdfToText\Pdf;
use Carbon\Carbon;
use Config;
Use App\User;
use App\ExternalReport;
use App\Dataset;

class ExternalReportController extends Controller
{
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
        return view('admin::external_report.index', compact('datasets'));
    }
    
    /**
     * datatable
     *
     * @param  mixed $request
     * @return void
     */
    public function datatable(Request $request)
    {   
        if ($request->ajax()) {
            //DB::enableQueryLog(); // Enable query log
            $external_report = ExternalReport::active()->orderBy('created_at','desc')->get();
            //dd(DB::getQueryLog()); // Show results of log
            return Datatables::of($external_report)
            ->addColumn('uploaded_by', function ($external_report) {
                return $external_report->users()->pluck('name')->toArray();
            })->rawColumns(['uploaded_by'])
            ->editColumn('created_at', function ($external_report) {
                return Carbon::parse($external_report->created_at, 'UTC')->setTimezone(auth()->user()->timezone);
            })->editColumn('updated_at', function ($external_report) {
                return Carbon::parse($external_report->updated_at, 'UTC')->setTimezone(auth()->user()->timezone);
            })->make(true);
        }
    }


    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $datasets = $this->datasets;
        return view('admin::external_report.create', compact('datasets'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:external_reports',
            'organization_name' => 'required',
            'type' => 'required',
            'comments' => 'required',
            'external_report' => 'required|mimes:pdf|max:51200s|clamav'
        ]);
        $external_report = [];
        if (!$validator->fails()) {

            //Generate EXR number for External Report
            $randomid = mt_rand(100000,999999); 
            $current_date_time = Carbon::now('UTC')->timestamp;
            
            $reportfilename = 'EXR-'.$randomid.'-'.$current_date_time;
            
            $external_report['title'] = $request->title;
            $external_report['organization_name'] = $request->organization_name;
            $external_report['organization_url'] = $request->organization_url;
            $external_report['type'] = $request->type;
            $external_report['comments'] = $request->comments;
            $external_report['uploaded_by'] = auth()->user()->id;
            $external_report['external_report'] = $reportfilename;
            
            
            //uploading file to directory
            Storage::putFileAs('external_report', $request->file('external_report'), $reportfilename.'.pdf', 'private');
            $pdf_path = storage_path('app/external_report/'.$reportfilename.'.pdf');
            //$text = Pdf::getText($pdf_path, Config::get('constants.pdftotext.lib_path'));
            //Storage::put('external_report/'.$reportfilename.'.txt', $text);

            
            if(ExternalReport::create($external_report)){
                flash('Successfully created external report.')->success();
            }
            else{
                flash('Failed to create external report.')->error();
            }
        }else{
            flash('Failed to create external report.')->error();
            return redirect()->back()
            ->withErrors($validator)
            ->withInput($request->input());
        }
        return redirect()->route('external_report.index');
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
                $external_report = ExternalReport::active()-> with(['tasks.fully_manual'])->where('id', $id)->firstOrFail();
                $analysts = User::role(['Analyst', 'Supervisor'])->pluck('name','id')->toArray(); 
                return view('admin::external_report.show',compact(['external_report', 'analysts']))->render();
            }
            catch(ModelNotFoundException $e)
            {
                return response()->json('External Report for this task has been deleted',302);
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
        $external_report = ExternalReport::where('id', $id)->first();
        return view('admin::external_report.edit', compact('external_report'))->render();
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $external_report = $request->file('external_report');
    
        $fileModel = ExternalReport::findOrFail($id);

        if($external_report != ''){
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'organization_name' => 'required',
                'comments' => 'required',
                'external_report' => 'required|mimes:pdf|max:51200|clamav'
            ]);

            if (!$validator->fails()) {

                //Generate INSR number for Institutional Report
                $randomid = mt_rand(100000,999999); 
                $current_date_time = Carbon::now('UTC')->timestamp;
                $reportfilename = 'EXR-'.$randomid.'-'.$current_date_time;
                
                

                $fileModel->fill(array(
                    'title' => $request->title,
                    'organization_name' => $request->organization_name,
                    'organization_url' => $request->organization_url,
                    'type' => $request->type,
                    'comments' => $request->comments,
                    'uploaded_by' => auth()->user()->id,
                    'external_report' => $reportfilename
                ));
    
                Storage::putFileAs('external_report', $request->file('external_report'), $reportfilename.'.pdf', 'private');
                
                $pdf_path = storage_path('app/external_report/'.$reportfilename.'.pdf');
                //$text = Pdf::getText($pdf_path, Config::get('constants.pdftotext.lib_path'));
                //Storage::put('external_report/'.$reportfilename.'.txt', $text);

                if($fileModel->save()){
                    flash('Successfully updated external report.')->success();
                }else{
                    flash('Failed to update external report.')->error();
                }
            }else{
                flash('Failed to update external report.')->error();
                return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
            }
        }else{
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'organization_name' => 'required',
                'comments' => 'required',
            ]);

            if (!$validator->fails()) {

                $fileModel->fill(array(
                    'title' => $request->title,
                    'organization_name' => $request->organization_name,
                    'organization_url' => $request->organization_url,
                    'type' => $request->type,
                    'comments' => $request->comments,
                ));
                
                if($fileModel->save()){
                    flash('Successfully updated external report.')->success();
                }else{
                    flash('Failed to update external report.')->error();
                }
            }else{
                flash('Failed to update external report.')->error();
                return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
            }
        }

        return redirect()->route('external_report.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $ids = explode(",",$id);
        $flag = true; //Flag for external report should not have link taks
        $flag1 = true; //Flag for user deleting report and uploaded by should match

        if(count($ids) > 1){
            $external_reports = ExternalReport::with(['tasks'])->whereIn('id',$ids)->get();
        }
        else{
            $external_reports = ExternalReport::with(['tasks'])->findorFail($ids);
        }

        foreach($external_reports as $external_report){
            if($external_report->tasks != null)
                $flag = false;
            else if($external_report->uploaded_by != auth()->user()->id)
                $flag1 = false;
        }

        if($flag1 == true){ //uploaded by
            if($flag == true){ // link task
                if( $external_report->delete() ) {
                    return 'success';
                } else {
                    return 'error';
                }
            }else{
                return response()->json('External Report with a task linked to it cannot be deleted', 302);
            }
        }else{
            return response()->json('only user who uploaded the report can delete it.', 302);
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
        $filepath = 'external_report/'.$filename.'.'.$filetype;
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
     * bulk_archive
     *
     * @param  mixed $id
     * @return void
    */
    public function bulk_archive(Request $request){

        parse_str($request->input('data'), $request);
        $ref_id = $request['external_report'];
        $external_report = ExternalReport::whereIn('external_report', $ref_id);
        
        if($external_report->update(['archive' => 1])) {
            return response()->json([
                'status'=>'Success',
                'message' => 'Report archived successfully',
                'data' => $external_report
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
        $flag = true; //Flag for external report should not have link taks
        $flag1 = true; //Flag for user deleting report and uploaded by should match
        $ref_id = $request['external_report'];
        $external_reports = ExternalReport::with(['tasks'])->whereIn('external_report',$ref_id)->get();

        foreach($external_reports as $external_report){
            if($external_report->tasks != null)
                $flag = false;
            else if($external_report->uploaded_by != auth()->user()->id)
                $flag1 = false;
        }

        if($flag1 == true){ // uploaded by
            if($flag == true){ // link task
                if($external_report->delete()) {
                    return response()->json([
                        'status'=>'Success',
                        'message' => 'Report deleted successfully',
                        'data' => $external_report
                    ], 200);
                }
                else{
                    return response()->json('Error - while deleting report',302);
                } 
            }else{
                return response()->json('External Report with a task linked to it cannot be deleted', 302);
            }
        }
        else{
            return response()->json('only user who uploaded the report can delete it.', 302);
        }
    }
    
    /**
     * unarchive
     *
     * @param  mixed $id
     * @return void
     */
    public function unarchive($id){
        
        $external_report = ExternalReport::where('id', $id)->firstOrFail();
        if($external_report->archive == 0){
            return response()->json([
                'status'=>'Error',
                'message' => 'Report already unarchived'
            ], 409);
        }else{
            $external_report->archive = 0;
            if($external_report->save()){
                return response()->json([
                    'status'=>'Success',
                    'message' => 'Report unarchived successfully'
                ], 200);
            }else{
                return response()->json('Error - while unarchiving report',302);
            }
        }
    }
}
