<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\FullyManual;
use App\Tasks;
use App\Sectors;
use App\FullyManualLinks;
use App\FullyManualGallery;
use App\Authorizable;
use App\Dataset;
use PDF;
use IMAGE;
use DB;

class FullyManualController extends Controller
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
        return view('admin::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {       
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'task_id' => 'required',
        ]);
        
        if ($validator->fails()){
            return response()->json($validator->errors()->first(), 302);
        }

        $fully_manual_report = FullyManual::inProgress()->where('task_id', $request->task_id)->first();
        if($fully_manual_report){
            return response()->json([
                'status' => 'success',
                'message' => 'Report already in Progress',
                'data' => $fully_manual_report
            ], 200);
        }

        $task = Tasks::findorFail($request->task_id);

        //Generate INSR number for Institutional Report
        $randomid = mt_rand(100000,999999); 
        $current_date_time = Carbon::now('UTC')->timestamp;
        $reportfilename = 'FMR-'.$randomid.'-'.$current_date_time;

        $request['type'] = $task->subject_type;
        $request['ref_id'] = $reportfilename;
        $request['report_by'] = auth()->user()->id;
        $request['status'] = 'progress';

        $manual_data = FullyManual::create($request->all());

        if($manual_data){
            return response()->json([
                'status' => 'success',
                'message' => 'Report data save successfully',
                'data' => $manual_data
            ], 200);
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create manual report'
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
        $fully_manual_report = FullyManual::with('sectors', 'gallery','task.alert.links','links')->findOrFail($id);
        if($fully_manual_report->task->alert != null){

            $alert_links = $fully_manual_report->task->alert->links->pluck('url')->toArray();
        }
        else{
            $alert_links = null;
        }
        $fully_manual_links = $fully_manual_report->links->pluck('url')->toArray();
        return view('report_template.manual', compact(['fully_manual_report','alert_links','fully_manual_links', 'datasets']));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $datasets = $this->datasets;
        $fully_manual_report = FullyManual::with('links')->inProgress()->findOrFail($id);
        $sectors = Sectors::all()->pluck("name", "id");
        
        if($fully_manual_report->type != 'external_report' && $fully_manual_report->type != 'institution_report' && $fully_manual_report->task->alert != null){
            $alert_links = $fully_manual_report->task->alert->links->pluck('url')->toArray();
        }
        else{
            $alert_links = null;
        }
        $fully_manual_links_array = $fully_manual_report->links->pluck('url')->toArray();
        return view('admin::fully_manual.edit', compact(['fully_manual_report', 'sectors','alert_links','fully_manual_links_array', 'datasets']));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $fully_manual_report = FullyManual::inProgress()->findOrFail($id);

        if($request->hasFile('file')){
            $validator = Validator::make($request->all(), [
                'file' => 'required|image|mimes:jpeg,png,jpg',
            ]);
            
            if ($validator->fails()){
                return response()->json($validator->errors()->first(), 302);
            }

            $image      = $request->file;
            $fileName   = time().'_'.$image->getClientOriginalName();
            if($image->storeAs('fully_manual/photos', $fileName)){
                $fully_manual_report->gallery()->save(new FullyManualGallery(['images' => $fileName]));     
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Images added successfully',
                'data' => $fully_manual_report->gallery->last()
            ], 200);
        }else{
            $update = $fully_manual_report->task()->update(['updated_at' => now()]);

            if($fully_manual_report->update($request->all())){

                //Sync Fully Manual Reference
                if($request->fully_manual_references != ''){
                    $request->fully_manual_references = preg_replace("/\r\n|[\r\n]/",",", $request->fully_manual_references);
                    
                    $fully_manual_references = explode(",",$request->fully_manual_references);
                    $fully_manual_report->links()->delete();
                    foreach($fully_manual_references as $key => $value){
                        $fully_manual_report->links()->save(new FullyManualLinks(['url' => $value]));
                    }
                    return response()->json([
                        'status' => 'success',
                        'message' => 'References added successfully',
                        'data' => $fully_manual_report->links->last()
                    ], 200);
                }
                
                return response()->json([
                    'status' => 'success',
                    'message' => 'Report data save successfully',
                    'data' => $fully_manual_report
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
        $fully_manual_report = FullyManual::with('sectors', 'gallery', 'links')->findOrFail($id);
        $fully_manual_links = $fully_manual_report->links->pluck('url')->toArray();
        
        $pdf = PDF::loadHTML(view('report_template.manual', compact(['fully_manual_report','fully_manual_links'])));
        $pdf->save(storage_path('app/fully_manual/'.$fully_manual_report->ref_id.'.pdf'), $overwrite = true);

        $fully_manual_report->status = 'complete';
        
        if($fully_manual_report->save()){
            flash('Report completed successfully')->success();
            return redirect()->route('tasks.index');    
        }else {
            return redirect()->back()
                        ->withErrors(['Failed to complete report'])
                        ->withInput();
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
        $filepath = 'fully_manual/'.$filename.'.'.$filetype;
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
        $fully_manual_report = FullyManual::where('id', $id)->firstOrFail();
        if($fully_manual_report->archive == 0){
            return response()->json([
                'status'=>'Error',
                'message' => 'Report already unarchived'
            ], 409);
        }else{
            $fully_manual_report->archive = 0;
            if($fully_manual_report->save()){
                return response()->json([
                    'status'=>'Success',
                    'message' => 'Fully Manual report unarchived successfully'
                ], 200);
            }else{
                return response()->json([
                    'status'=>'Error',
                    'message' => 'Error - while unarchiving fully manual report'
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
        $ref_id = $request['fully_manual'];
        $fully_manual_report = FullyManual::whereIn('ref_id', $ref_id);
        
        if($fully_manual_report->update(['archive' => 1])) {
            return response()->json([
                'status'=>'Success',
                'message' => 'Report archived successfully',
                'data' => $fully_manual_report
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
        $ref_id = $request['fully_manual'];
        $fully_manual_report = FullyManual::whereIn('ref_id', $ref_id);
        
        if($fully_manual_report->delete()) {
            return response()->json([
                'status'=>'Success',
                'message' => 'Report deleted successfully',
                'data' => $fully_manual_report
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
        $fully_manual_report = FullyManual::where('id', $id)->firstOrFail();
        if($fully_manual_report->status == 'progress'){
            return response()->json([
                'status'=>'Error',
                'message' => "Report can't be continued, already in pending status"
            ], 409);
        }else{
            $fully_manual_report->status = 'progress';
            if($fully_manual_report->save()){
                return response()->json([
                    'status'=>'Success',
                    'message' => 'Report reopened successfully',
                    'id' => $fully_manual_report->id
                ], 200);
            }else{
                return response()->json('Error - while continuing report',302);
            }
        }
    }
}
