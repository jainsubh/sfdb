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
use App\VideoReport;
use App\Dataset;

class VideoReportController extends Controller
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
        return view('admin::video_report.index', compact('datasets'));
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
            $video_report = VideoReport::active()->orderBy('created_at','desc')->get();
            //dd(DB::getQueryLog()); // Show results of log
            return Datatables::of($video_report)
            ->addColumn('uploaded_by', function ($video_report) {
                return $video_report->users()->pluck('name')->toArray();
            })->rawColumns(['uploaded_by'])
            ->editColumn('created_at', function ($video_report) {
                return Carbon::parse($video_report->created_at, 'UTC')->setTimezone(auth()->user()->timezone);
            })->editColumn('updated_at', function ($video_report) {
                return Carbon::parse($video_report->updated_at, 'UTC')->setTimezone(auth()->user()->timezone);
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
        return view('admin::video_report.create', compact('datasets'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:video_report',
            'organization_name' => 'required',
            'comments' => 'required',
            'video_report' => 'required|mimes:mp4,mov,ogg|max:500000'
        ]);
        $video_report = [];
        if (!$validator->fails()) {

            //Generate VIR number for video Report
            $randomid = mt_rand(100000,999999); 
            $current_date_time = Carbon::now('UTC')->timestamp;
            
            $reportfilename = 'VIR-'.$randomid.'-'.$current_date_time;
            
            $video_report['title'] = $request->title;
            $video_report['organization_name'] = $request->organization_name;
            $video_report['organization_url'] = $request->organization_url;
            $video_report['comments'] = $request->comments;
            $video_report['uploaded_by'] = auth()->user()->id;
            $video_report['video_report'] = $reportfilename;
            
            
            //uploading file to directory
            Storage::putFileAs('video_report', $request->file('video_report'), $reportfilename.'.mp4', 'private');
            //$mp4_path = storage_path('app/video_report/'.$reportfilename.'.mp4');
            //$text = Pdf::getText($pdf_path, Config::get('constants.pdftotext.lib_path'));
            //Storage::put('video_report/'.$reportfilename.'.txt', $text);

            
            if(videoReport::create($video_report)){
                flash('Successfully created video report.')->success();
            }
            else{
                flash('Failed to create video report.')->error();
            }
        }else{
            flash('Failed to create video report.')->error();
            return redirect()->back()
            ->withErrors($validator)
            ->withInput($request->input());
        }
        return redirect()->route('video_report.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('admin::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $video_report = VideoReport::where('id', $id)->first();
        return view('admin::video_report.edit', compact('video_report'))->render();
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $video_report = $request->file('video_report');
    
        $fileModel = VideoReport::findOrFail($id);

        if($video_report != ''){
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'organization_name' => 'required',
                'comments' => 'required',
                'video_report' => 'required|mimes:mp4,mov,ogg|max:500000'
            ]);

            if (!$validator->fails()) {

                //Generate INSR number for Institutional Report
                $randomid = mt_rand(100000,999999); 
                $current_date_time = Carbon::now('UTC')->timestamp;
                $reportfilename = 'VIR-'.$randomid.'-'.$current_date_time;
                
                

                $fileModel->fill(array(
                    'title' => $request->title,
                    'organization_name' => $request->organization_name,
                    'organization_url' => $request->organization_url,
                    'comments' => $request->comments,
                    'uploaded_by' => auth()->user()->id,
                    'video_report' => $reportfilename
                ));
    
                Storage::putFileAs('video_report', $request->file('video_report'), $reportfilename.'.mp4', 'private');
                
                //$mp4_path = storage_path('app/video_report/'.$reportfilename.'.mp4');
                //$text = Pdf::getText($pdf_path, Config::get('constants.pdftotext.lib_path'));
                //Storage::put('video_report/'.$reportfilename.'.txt', $text);

                if($fileModel->save()){
                    flash('Successfully updated video report.')->success();
                }else{
                    flash('Failed to update video report.')->error();
                }
            }else{
                flash('Failed to update video report.')->error();
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
                    'comments' => $request->comments,
                ));
                
                if($fileModel->save()){
                    flash('Successfully updated video report.')->success();
                }else{
                    flash('Failed to update video report.')->error();
                }
            }else{
                flash('Failed to update video report.')->error();
                return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
            }
        }

        return redirect()->route('video_report.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $ids = explode(",",$id);
        if(count($ids) > 1){
            $video_report = VideoReport::whereIn('id',$ids);
        }
        else{
            $video_report = VideoReport::where('id',$ids);
        }
        if( $video_report->delete() ) {
            return 'success';
        } else {
            return 'error';
        }
    }
    
    /**
     * download
     *
     * @param  mixed $filename
     * @param  mixed $filetype
     * @return void
     */
    public function download($filename, $filetype = 'mp4')
    {
        $filepath = 'video_report/'.$filename.'.'.$filetype;
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
        $ref_id = $request['video_report'];
        $video_report = VideoReport::whereIn('video_report', $ref_id);
        
        if($video_report->update(['archive' => 1])) {
            return response()->json([
                'status'=>'Success',
                'message' => 'Report archived successfully',
                'data' => $video_report
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
        $ref_id = $request['video_report'];
        $video_report = VideoReport::whereIn('video_report', $ref_id);
        
        if($video_report->delete()) {
            return response()->json([
                'status'=>'Success',
                'message' => 'Report deleted successfully',
                'data' => $video_report
            ], 200);
        }
        else{
            return response()->json('Error - while deleting report',302);
        } 
    }
    
    /**
     * unarchive
     *
     * @param  mixed $id
     * @return void
     */
    public function unarchive($id){
        
        $video_report = VideoReport::where('id', $id)->firstOrFail();
        if($video_report->archive == 0){
            return response()->json([
                'status'=>'Error',
                'message' => 'Report already unarchived'
            ], 409);
        }else{
            $video_report->archive = 0;
            if($video_report->save()){
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
