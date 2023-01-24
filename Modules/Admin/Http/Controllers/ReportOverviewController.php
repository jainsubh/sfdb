<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use App\Authorizable;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\SemiAutomatic;
use App\InstitutionReport;
use App\FreeFormReport;
use App\ExternalReport;
use App\VideoReport;
use App\User;
use App\Alert;
use App\FullyManual;
use App\Dataset;
use App\DatasetData;

use DB;
use Zip;

class ReportOverviewController extends Controller
{
    use Authorizable;
    
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function all(Request $request){
        
        //Validation Checks for the form fields
        $validator = Validator::make($request->all(), [
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date',
        ]);
        
        if ($validator->fails()) {
            flash($validator->messages()->first())->error();
            return redirect()->route('all')
                        ->withErrors($validator)
                        ->withInput();
        }
        
        //to Get only last 7 days data by Default on page load
        $request['default_from_date']  = Carbon::today()->subDays(6)->toDateString();
        $request['default_to_date']  = Carbon::today()->toDateString();

        $dataset_lookup = $request->dataset;

        $dataset = Dataset::with(['data'])->get();
        $data_arr = new Dataset;
        $dataset_arr = $data_arr->datasetWithData($dataset);
        
        //$system_generated_report = $this->system_generated_report($request);
        //$semi_automatic_report = $this->semi_automatic_report($request);
        //$institution_report = $this->institution_report($request);
        $freeform_report = $this->freeform_report($request); //manual report
        $external_report = $this->external_report($request); //manual report
        $scenario_report = $this->scenario_report($request); //manual report
        $video_report = $this->video_report($request); //manual report
        $fully_manual = $this->fully_manual($request); //manual report
        
        $alerts = $this->getAlertTitle();
        $analysts = $this->getAnalyst();
        
        return view('report-overview', compact('scenario_report','external_report','video_report','freeform_report','fully_manual','alerts','analysts', 'dataset', 'dataset_arr', 'dataset_lookup'))->with('name', 'reports library');
    }
    
    /**
     * institution_report
     *
     * @param  mixed $request
     * @return void
     */
    public function institution_report(Request $request){
        $institution_report = InstitutionReport::with('tasks')->active()->isLibrary();
       
        $request['default_from_date']  = Carbon::today()->subDays(6)->toDateString();
        $request['default_to_date']  = Carbon::today()->toDateString();

        $this->institutional_report_search($institution_report, $request);

        $institution_report = $institution_report->orderBy('date_time','desc')->paginate(18);
        if(Route::currentRouteName() == 'all'){
            return $institution_report;
        }else{
            $analysts = $this->getAnalyst();
            $alerts = $this->getAlertTitle();
            
            return view('library', compact('institution_report','alerts','analysts'))->with('name', 'reports library');
        }
    }
    
    /**
     * freeform_report
     *
     * @param  mixed $request
     * @return void
     */
    public function freeform_report(Request $request){
       
        $freeform_report = FreeFormReport::with('tasks', 'data', 'report_countries', 'report_countries.country')->active()->isLibrary();
        
        if($request->id){
            $freeform_report = $freeform_report->find($request->id);
        }else{
            $this->freeform_report_search($freeform_report, $request);
            $freeform_report = $freeform_report->orderBy('date_time','desc');
            $freeform_report = $freeform_report->get();
        }
        return $freeform_report;
        
    }
    
    /**
     * external_report
     *
     * @param  mixed $request
     * @return void
     */
    public function external_report(Request $request){
        
        $external_report = ExternalReport::active()->externalReport()->isLibrary();

        $request['default_from_date']  = Carbon::today()->subDays(6)->toDateString();
        $request['default_to_date']  = Carbon::today()->toDateString();

        $this->external_report_search($external_report, $request);
        $external_report = $external_report->orderBy('created_at','desc')->paginate(18);

        return $external_report;
        
    }

    public function scenario_report(Request $request){

        $scenario_report = ExternalReport::active()->scenarioReport()->isLibrary();

        $request['default_from_date'] = Carbon::today()->subDays(6)->toDateString();
        $request['default_to_date']  = Carbon::today()->toDateString();

        $this->external_report_search($scenario_report, $request);
        $scenario_report = $scenario_report->orderBy('created_at','desc')->paginate(18);

        return $scenario_report;
    }
    
    /**
     * video_report
     *
     * @param  mixed $request
     * @return void
     */
    public function video_report(Request $request){
        
        $video_report = VideoReport::active()->isLibrary();
        

        $request['default_from_date']  = Carbon::today()->subDays(6)->toDateString();
        $request['default_to_date'] = Carbon::today()->toDateString();

        $this->video_report_search($video_report, $request);
        $video_report = $video_report->orderBy('created_at','desc')->paginate(18);

        return $video_report;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function semi_automatic_report(Request $request){

        //Retreiving latest new tasks that are have been completed
        $semi_automatic_report = SemiAutomatic::isActive()->hasCompleted()->with(['alert', 'reported_by']);
        

        $request['default_from_date']  = Carbon::today()->subDays(6)->toDateString();
        $request['default_to_date']  = Carbon::today()->toDateString();

        $this->semi_automatic_report_search($semi_automatic_report, $request);

        $semi_automatic_report = $semi_automatic_report->orderBy('updated_at','desc')->paginate(18);
        
        return $semi_automatic_report;
    }
 
    /**
     * fully_manual
     *
     * @param  mixed $search_filter
     * @return void
     */
    public function fully_manual(Request $request){
        
        $fully_manual = FullyManual::isActive()->hasCompleted()->with('reported_by');

        $request['default_from_date']  = Carbon::today()->subDays(6)->toDateString();
        $request['default_to_date']  = Carbon::today()->toDateString();
        
        $this->fully_manual_report_search($fully_manual, $request);

        $fully_manual = $fully_manual->orderBy('updated_at','desc')->paginate(18);

        return $fully_manual;
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function download_zip(){
        $zip_path = storage_path('file.zip');
        if (file_exists($zip_path)) {
            return response()->download($zip_path, 'reports.zip', array('Content-Type: application/octet-stream','Content-Length: '. filesize($zip_path)))->deleteFileAfterSend(true);
        } else {
            return ['status'=>'zip file does not exist'];
        }
    }

    /**
     * getAnalyst
     *
     * @return void
     */
    private function getAnalyst(){
        return User::role(['Analyst', 'Supervisor'])->pluck('name','id')->toArray();
    }
    
    /**
     * getAlertTitle
     *
     * @return void
     */
    private function getAlertTitle(){
        //Showing alerts on manager dashboard
        return Alert::active()->latest()->take(10)->get();
    }
    
    /**
     * external_report_search
     *
     * @param  mixed $external_report
     * @param  mixed $request
     * @return void
     */
    private function external_report_search($external_report, $request){
        if(auth()->user()->hasRole('Analyst')){
            $external_report->ownTasks();
        }
        if($request->has('analysts') || $request->has('from_date') || $request->has('to_date') || $request->has('search_title') || $request->has('search_ref_id'))
        {
            if($request['analysts'] != ""){
                $external_report->where('uploaded_by',$request['analysts']);
            }

            if($request['from_date'] != ""){
                $date = Carbon::parse($request['from_date'],auth()->user()->timezone)->setTimezone('utc');
                $external_report->where('created_at', '>=', $date);
            }
                
            if($request['to_date'] != ""){
                $date = Carbon::parse($request['to_date'], auth()->user()->timezone)->setTimezone('UTC')->addDay(1);
                $external_report->where('created_at', '<=', $date);
            }

            if($request['search_title'] != ""){
                $external_report->where('title', 'like', '%'.$request['search_title'].'%');
            }

            if($request['search_ref_id'] != ""){
                $external_report->where('external_report', 'like', '%'.$request['search_ref_id'].'%');
            }
                
        }else if($request['default_from_date'] != "" && $request['default_to_date'] != ""){
            $default_from_date = Carbon::parse($request['default_from_date'],auth()->user()->timezone)->setTimezone('utc');
            $default_to_date = Carbon::parse($request['default_to_date'], auth()->user()->timezone)->setTimezone('UTC')->addDay(1);
            $external_report->where('created_at', '<=', $default_to_date);
            $external_report->where('created_at', '>=', $default_from_date);
        }
    }
      
    /**
     * video_report_search
     *
     * @param  mixed $video_report
     * @param  mixed $request
     * @return void
     */
    private function video_report_search($video_report, $request){
        
        if($request->has('analysts') || $request->has('from_date') || $request->has('to_date') || $request->has('search_title') || $request->has('search_ref_id'))
        {
            if($request['analysts'] != ""){
                $video_report->where('uploaded_by',$request['analysts']);
            }

            if($request['from_date'] != ""){
                $date = Carbon::parse($request['from_date'],auth()->user()->timezone)->setTimezone('utc');
                $video_report->where('created_at', '>=', $date);
            }
                
            if($request['to_date'] != ""){
                $date = Carbon::parse($request['to_date'], auth()->user()->timezone)->setTimezone('UTC')->addDay(1);
                $video_report->where('created_at', '<=', $date);
            }

            if($request['search_title'] != ""){
                $video_report->where('title', 'like', '%'.$request['search_title'].'%');
            }

            if($request['search_ref_id'] != ""){
                $video_report->where('video_report', 'like', '%'.$request['search_ref_id'].'%');
            }
                
        }else if($request['default_from_date'] != "" && $request['default_to_date'] != ""){
            $default_from_date = Carbon::parse($request['default_from_date'],auth()->user()->timezone)->setTimezone('utc');
            $video_report->where('created_at', '>=', $default_from_date);
            $default_to_date = Carbon::parse($request['default_to_date'], auth()->user()->timezone)->setTimezone('UTC')->addDay(1);
            $video_report->where('created_at', '<=', $default_to_date);
        }
    }
    
    /**
     * freeform_report_search
     *
     * @param  mixed $institution_report
     * @param  mixed $request
     * @return void
     */
    private function freeform_report_search($freeform_report, $request){
        if(auth()->user()->hasRole('Analyst')){
            $freeform_report->own();
        }
        if($request->has('analysts') || $request->has('from_date') || $request->has('to_date') || $request->has('search_title') || $request->has('search_ref_id'))
        {
            /*
            if($request['analysts'] != ""){
                $freeform_report->whereHas('tasks', function($query) use ($request){ 
                    $query->whereHas('latest_task_log',  function($q) use ($request){  
                        $q->where('assigned_to', $request['analysts']);
                    });
                });
            }
            
            if($request['from_date'] != ""){
                $date = Carbon::parse($request['from_date'],auth()->user()->timezone)->setTimezone('utc');
                $freeform_report->where('date_time', '>=', $date);
            }
                
            if($request['to_date'] != ""){
                $date = Carbon::parse($request['to_date'], auth()->user()->timezone)->setTimezone('UTC')->addDay(1);
                $freeform_report->where('date_time', '<=', $date);
            }
            */

            if($request['search_title'] != ""){
                $freeform_report->where('title', 'like', '%'.$request['search_title'].'%');
            }

            if($request['search_ref_id'] != ""){
                $freeform_report->where('ref_id', 'like', '%'.$request['search_ref_id'].'%');
            }

            if($request['dataset'] != ""){
                $freeform_report->whereHas('data', function($query) use ($request){ 
                    //change request param to get all selected unique data id 
                    $dataset_filter = [];
                    foreach($request['dataset'] as $key => $item){
                        $dataset_filter = array_merge($dataset_filter, $item);
                    }
                    $query->whereIn('data_id', $dataset_filter);
                    /*
                    $query->whereHas('latest_task_log',  function($q) use ($request){  
                        $q->where('assigned_to', $request['analysts']);
                    });
                    */
                });
            }
                
        }
        /*
        else if($request['default_from_date'] != "" && $request['default_to_date'] != ""){
            
            $default_from_date = Carbon::parse($request['default_from_date'],auth()->user()->timezone)->setTimezone('utc');
            $freeform_report->where('date_time', '>=', $default_from_date);
            $default_to_date = Carbon::parse($request['default_to_date'], auth()->user()->timezone)->setTimezone('UTC')->addDay(1);
            $freeform_report->where('date_time', '<=', $default_to_date);
        }
        */
    }
    
    /**
     * semi_automatic_report_search
     *
     * @return void
     */
    private function semi_automatic_report_search($semi_automatic_report, $request){
        if(auth()->user()->hasRole('Analyst')){
            $semi_automatic_report->own();
        }

        if($request->has('analysts') || $request->has('from_date') || $request->has('to_date') || $request->has('search_title') ||  $request->has('search_ref_id') ){
            if(auth()->user()->hasRole('Manager') && $request['analysts'] != ""){
                $semi_automatic_report->where('report_by',$request['analysts']);
            }
            if($request['from_date'] != ""){
                $date = Carbon::parse($request['from_date'],auth()->user()->timezone)->setTimezone('utc');
                $semi_automatic_report->where('updated_at','>=',$date);
            }
            if( $request['to_date'] != ""){
                $date = Carbon::parse($request['to_date'], auth()->user()->timezone)->setTimezone('utc')->addDay(1);
                $semi_automatic_report->where('updated_at', '<=', $date);
            }
            if($request['search_title'] != ""){
                $semi_automatic_report->whereHas('alert', function($q) use ($request){ 
                    $q->where('title','like','%'.$request['search_title'].'%');
                });
            }

            if($request['search_ref_id'] != ""){
                $semi_automatic_report->where('ref_id','like','%'.$request['search_ref_id'].'%');
            }
        }else if($request['default_from_date'] != "" && $request['default_to_date'] != ""){
            $default_from_date = Carbon::parse($request['default_from_date'],auth()->user()->timezone)->setTimezone('utc');
            $semi_automatic_report->where('updated_at','>=',$default_from_date);
            $default_to_date = Carbon::parse($request['default_to_date'], auth()->user()->timezone)->setTimezone('utc')->addDay(1);
            $semi_automatic_report->where('updated_at', '<=', $default_to_date);
        }
    }
    
    /**
     * fully_manual_report_search
     *
     * @param  mixed $fully_manual
     * @param  mixed $request
     * @return void
     */
    private function fully_manual_report_search($fully_manual, $request){
        if(auth()->user()->hasRole('Analyst')){
            $fully_manual->own();
        }
        
        if($request->has('analysts') || $request->has('from_date') || $request->has('to_date') || $request->has('search_title') || $request->has('search_ref_id') ){
            if(auth()->user()->hasRole('Manager') && $request['analysts'] != ""){
                $fully_manual->where('report_by',$request['analysts']);
            }
            if($request['from_date'] != ""){
                $date = Carbon::parse($request['from_date'],auth()->user()->timezone)->setTimezone('utc');
                $fully_manual->where('updated_at','>=',$date);
            }
                
            if($request['to_date'] != ""){
                $date = Carbon::parse($request['to_date'], auth()->user()->timezone)->setTimezone('UTC')->addDay(1);
                $fully_manual->where('updated_at','<=',$date);
            }  

            if($request['search_title'] != ""){
                $fully_manual->where('title','like','%'.$request['search_title'].'%');
            }

            if($request['search_ref_id'] != ""){
                $fully_manual->where('ref_id','like','%'.$request['search_ref_id'].'%');
            }
        }else if($request['default_from_date'] != "" && $request['default_to_date'] != ""){
            $default_from_date = Carbon::parse($request['default_from_date'],auth()->user()->timezone)->setTimezone('utc');
            $fully_manual->where('updated_at','>=',$default_from_date);
            $default_to_date = Carbon::parse($request['default_to_date'], auth()->user()->timezone)->setTimezone('UTC')->addDay(1);
            $fully_manual->where('updated_at','<=',$default_to_date);
        }
    }

    public function report_detail($type, Request $request){
        $alerts = $this->getAlertTitle();
        $report = $this->$type($request);
        //dd($report);
        return view('report-detail', compact('report', 'alerts'))->with('name', 'Report Detail');
    }
}
