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
use DB;
use Zip;

class LibraryController extends Controller
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
        //die('before  institution_report');
        $institution_report = $this->institution_report($request);
        //die('after  institution_report');
        $freeform_report = $this->freeform_report($request);
        $external_report = $this->external_report($request);
        $scenario_report = $this->scenario_report($request);
        
        $video_report = $this->video_report($request);
        $semi_automatic_report = $this->semi_automatic_report($request);
        $system_generated_report = $this->system_generated_report($request);
        $fully_manual = $this->fully_manual($request);
        //die('after fully manual');
        $alerts = $this->getAlertTitle();
        $analysts = $this->getAnalyst();
        
        return view('library', compact('institution_report','scenario_report','external_report','video_report','freeform_report','fully_manual','semi_automatic_report','system_generated_report','alerts','analysts'))->with('name', 'reports library');
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
        
        $freeform_report = FreeFormReport::with('tasks')->active()->isLibrary();

        $request['default_from_date']  = Carbon::today()->subDays(6)->toDateString();
        $request['default_to_date']  = Carbon::today()->toDateString();

        $this->freeform_report_search($freeform_report, $request);

        $freeform_report = $freeform_report->orderBy('date_time','desc')->paginate(18);
        if(Route::currentRouteName() == 'all'){
            return $freeform_report;
        }else{
            $analysts = $this->getAnalyst();
            $alerts = $this->getAlertTitle();
            return view('library', compact('freeform_report','alerts','analysts'))->with('name', 'reports library');
        }
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

        if(Route::currentRouteName() == 'all'){
            return $external_report;
        }else{
            $analysts = $this->getAnalyst();
            $alerts = $this->getAlertTitle();
            return view('library', compact('external_report','alerts','analysts'))->with('name', 'reports library');
        }
        
    }

    public function scenario_report(Request $request){

        $scenario_report = ExternalReport::active()->scenarioReport()->isLibrary();

        $request['default_from_date'] = Carbon::today()->subDays(6)->toDateString();
        $request['default_to_date']  = Carbon::today()->toDateString();

        $this->external_report_search($scenario_report, $request);
        $scenario_report = $scenario_report->orderBy('created_at','desc')->paginate(18);

        if(Route::currentRouteName() == 'all'){
            return $scenario_report;
        }else{
            $analysts = $this->getAnalyst();
            $alerts = $this->getAlertTitle();
            return view('library', compact('scenario_report','alerts','analysts'))->with('name', 'reports library');
        }
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

        if(Route::currentRouteName() == 'all'){
            return $video_report;
        }else{
            $analysts = $this->getAnalyst();
            $alerts = $this->getAlertTitle();
            return view('library', compact('video_report','alerts','analysts'))->with('name', 'reports library');
        }
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
        
        if(Route::currentRouteName() == 'all'){
            return $semi_automatic_report;
        }else{
            $analysts = $this->getAnalyst();
            $alerts = $this->getAlertTitle();
            return view('library', compact('semi_automatic_report','alerts','analysts'))->with('name', 'reports library');
        }
    }
    
    /**
     * system_generated_report
     *
     * @return void
     */
    public function system_generated_report(Request $request){
        

        if(auth()->user()->hasRole('Analyst')){
            $system_generated_report = Alert::ownAlerts()->active();
        }
        else{
            $system_generated_report = Alert::active()->with(['tasks.latest_task_log']);
        }

        $request['default_from_date']  = Carbon::today()->subDays(6)->toDateString();
        $request['default_to_date']  = Carbon::today()->toDateString();
                                    
        $this->alert_search($system_generated_report, $request);

        $system_generated_report = $system_generated_report->latest('id')->paginate(18);
        
        if(Route::currentRouteName() == 'all'){
            return $system_generated_report;
        }else{
            $analysts = $this->getAnalyst();
            $alerts = $this->getAlertTitle();
            return view('library', compact('system_generated_report', 'alerts', 'analysts'))->with('name', 'reports library');
        }
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

        if(Route::currentRouteName() == 'all'){
            return $fully_manual;
        }else{
            $analysts = $this->getAnalyst();
            $alerts = $this->getAlertTitle();
            return view('library', compact('fully_manual','alerts','analysts'))->with('name', 'reports library');
        }
    }
    
    /**
     * archived
     *
     * @return void
     */
    public function archived(Request $request){
        $institution_report_archived = InstitutionReport::with('tasks')->archive();
        $freeform_report_archived = FreeFormReport::with('tasks')->archive();
        $external_report_archived = ExternalReport::externalReport()->archive();
        $scenario_report_archived = ExternalReport::scenarioReport()->archive();
        $video_report_archived = VideoReport::archive();
        $alert_archived = Alert::with('tasks')->archive();
        $semi_automatic_report_archived = SemiAutomatic::with('tasks')->archive();
        $fully_manual_archived = FullyManual::with('task')->archive();
        
        $analysts = $this->getAnalyst();
        $alerts = $this->getAlertTitle();

        //to Get only last 7 days data by Default on page load
        $request['default_from_date']  = Carbon::today()->subDays(6)->toDateString();
        $request['default_to_date']  = Carbon::today()->toDateString();

        //search
        $this->institutional_report_search($institution_report_archived, $request);
        $this->freeform_report_search($freeform_report_archived, $request);
        $this->external_report_search($external_report_archived, $request);
        $this->external_report_search($scenario_report_archived, $request);
        $this->video_report_search($video_report_archived, $request);
        $this->alert_search($alert_archived, $request);
        $this->semi_automatic_report_search($semi_automatic_report_archived, $request);
        $this->fully_manual_report_search($fully_manual_archived, $request);

        $institution_report_archived = $institution_report_archived->orderBy('date_time','desc')->paginate(18);
        $freeform_report_archived = $freeform_report_archived->orderBy('date_time','desc')->paginate(18);
        $external_report_archived = $external_report_archived->orderBy('created_at','desc')->paginate(18);
        $scenario_report_archived = $scenario_report_archived->orderBy('created_at','desc')->paginate(18);
        $video_report_archived = $video_report_archived->orderBy('created_at','desc')->paginate(18);
        $alert_archived = $alert_archived->orderBy('created_at','desc')->paginate(18);
        $semi_automatic_report_archived = $semi_automatic_report_archived->orderBy('updated_at','desc')->paginate(18);
        $fully_manual_archived = $fully_manual_archived->orderBy('updated_at','desc')->paginate(18);

        return view('library', compact('institution_report_archived','external_report_archived','scenario_report_archived','video_report_archived','freeform_report_archived','alert_archived','semi_automatic_report_archived','fully_manual_archived','alerts','analysts'))->with('name', 'reports library');
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
     * bulk_downoad
     *
     * @param  mixed $request
     * @return void
     */
    public function bulk_download(Request $request, $type){
        parse_str($request->input('data'), $request);

        $zip_path = storage_path('file.zip');
        $zip = Zip::create($zip_path);
        
        // using array as parameter
        $sar_files = []; //System Automatic Report
        $fmr_files = []; //Fully Manual Report
        $insr_files = []; //Institution Report
        $ff_files = []; //FreeForm Report
        $nsr_files = []; //Alert Report

        if(($type == 'semi_automatic_report' || $type == 'all') && array_key_exists('semi_automatic_report',$request)){
            
            $sar_files = array_map(function($value){
                return storage_path('/app/semi-automatic/'.$value.'.pdf');
            }, $request['semi_automatic_report']);
            
        }
        if(($type == 'fully_manual' || $type == 'all') && array_key_exists('fully_manual',$request)){

            $fmr_files = array_map(function($value){
                return storage_path('/app/fully_manual/'.$value.'.pdf');
            }, $request['fully_manual']);
        }
        if(($type == 'institution_report' || $type == 'all') && array_key_exists('institution_report',$request)){
            
            $insr_files = array_map(function($value){
                return storage_path('/app/institution_report/'.$value.'.pdf');
            }, $request['institution_report']);
        }
        if(($type == 'external_report' || $type == 'scenario_report' || $type == 'all') && array_key_exists('external_report',$request)){
            
            $insr_files = array_map(function($value){
                return storage_path('/app/external_report/'.$value.'.pdf');
            }, $request['external_report']);
        }
        if(($type == 'video_report' || $type == 'all') && array_key_exists('video_report',$request)){
            
            $insr_files = array_map(function($value){
                return storage_path('/app/video_report/'.$value.'.mp4');
            }, $request['video_report']);
        }
        if(($type == 'freeform_report' || $type == 'all') && array_key_exists('freeform_report',$request)){
           
            $ff_files = array_map(function($value){
                return storage_path('app/freeform_report/'.$value.'.pdf');
            }, $request['freeform_report']);
        }
        if(($type == 'alerts' || $type == 'all') && array_key_exists('alerts',$request)){
           
            $nsr_files = array_map(function($value){
                return storage_path('/app/system_generated_report/'.$value.'.pdf');
            }, $request['alerts']);
        }

        $ref_files = array_merge($insr_files, $ff_files, $sar_files, $fmr_files, $nsr_files);
    
        if(count($ref_files) > 0){
            $zip->add($ref_files);
            $zip->close();
            if (file_exists($zip_path)) {
                return ['zip_path' => route('library.download_zip')];
            } else {
                return response()->json('Error - zip file does not exist',302);
            }
        }else{
            return response()->json('Error - Select any report or report not available yet',302);
        }
        
    }
    
    /**
     * bulk_archive
     *
     * @return void
     */
    public function bulk_archive(Request $request){
        
        parse_str($request->input('data'), $request);
        $flag = 0;
        if(array_key_exists('institution_report',$request)){
            $ir_ref_id = $request['institution_report'];
            $institution_report = InstitutionReport::whereIn('institution_report', $ir_ref_id);
            $flag = $institution_report->update(['archive' => 1]);
        }

        if(array_key_exists('freeform_report',$request)){
            $ff_ref_id = $request['freeform_report'];
            $freeform_report = FreeFormReport::whereIn('ref_id', $ff_ref_id);
            $flag = $freeform_report->update(['archive' => 1]);
        }

        if(array_key_exists('external_report',$request)){
            $exr_ref_id = $request['external_report'];
            $external_report = ExternalReport::whereIn('external_report', $exr_ref_id);
            $flag = $external_report->update(['archive' => 1]);
        }

        if(array_key_exists('video_report',$request)){
            $exr_ref_id = $request['video_report'];
            $video_report = VideoReport::whereIn('video_report', $exr_ref_id);
            $flag = $video_report->update(['archive' => 1]);
        }

        if(array_key_exists('alerts',$request)){
            $alert_ref_id = $request['alerts'];
            $alert = Alert::whereIn('ref_id', $alert_ref_id);
            $flag = $alert->update(['archive' => 1]);
        }

        if(array_key_exists('semi_automatic_report',$request)){
            $semi_automatic_ref_id = $request['semi_automatic_report'];
            $semi_automatic_report = SemiAutomatic::whereIn('ref_id', $semi_automatic_ref_id);
            $flag = $semi_automatic_report->update(['archive' => 1]);
        }

        if(array_key_exists('fully_manual',$request)){
            $fully_manual_ref_id = $request['fully_manual'];
            $fully_manual_report = FullyManual::whereIn('ref_id', $fully_manual_ref_id);
            $flag = $fully_manual_report->update(['archive' => 1]);
        }

        if($flag){ 
            return response()->json([
                'status'=> 'Success',
                'message' => 'Reports archived successfully'
            ], 200);
        }else{
            return response()->json('Error - while archiving reports',302);
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
        $flag = 0;
        if(array_key_exists('institution_report',$request)){
            $ir_ref_id = $request['institution_report'];
            $institution_report = InstitutionReport::whereIn('institution_report', $ir_ref_id);
            $flag = $institution_report->delete();
        }

        if(array_key_exists('freeform_report',$request)){
            $ff_ref_id = $request['freeform_report'];
            $freeform_report = FreeFormReport::whereIn('ref_id', $ff_ref_id);
            $flag = $freeform_report->delete();
        }

        if(array_key_exists('external_report',$request)){
            $exr_ref_id = $request['external_report'];
            $external_report = ExternalReport::whereIn('external_report', $exr_ref_id);
            $flag = $external_report->delete();
        }

        if(array_key_exists('video_report',$request)){
            $exr_ref_id = $request['video_report'];
            $video_report = VideoReport::whereIn('video_report', $exr_ref_id);
            $flag = $video_report->delete();
        }

        if(array_key_exists('alerts',$request)){
            $alert_ref_id = $request['alerts'];
            $alert = Alert::whereIn('ref_id', $alert_ref_id);
            $flag = $alert->delete();
        }

        if(array_key_exists('semi_automatic_report',$request)){
            $semi_automatic_ref_id = $request['semi_automatic_report'];
            $semi_automatic_report = SemiAutomatic::whereIn('ref_id', $semi_automatic_ref_id);
            $flag = $semi_automatic_report->delete();
        }

        if(array_key_exists('fully_manual',$request)){
            $fully_manual_ref_id = $request['fully_manual'];
            $fully_manual_report = FullyManual::whereIn('ref_id', $fully_manual_ref_id);
            $flag = $fully_manual_report->delete();
        }

        if($flag){ 
            return response()->json([
                'status'=> 'Success',
                'message' => 'Reports deleted successfully'
            ], 200);
        }else{
            return response()->json('Error - while deleting reports',302);
        }
    }
    
    /**
     * bulk_unarchive
     *
     * @param  mixed $request
     * @return void
     */
    public function bulk_unarchive(Request $request){
        
        parse_str($request->input('data'), $request);
        $flag = 0;
        if(array_key_exists('institution_report',$request)){
            $ir_ref_id = $request['institution_report'];
            $institution_report = InstitutionReport::whereIn('institution_report', $ir_ref_id);
            $flag = $institution_report->update(['archive' => 0]);
        }

        if(array_key_exists('freeform_report',$request)){
            $ff_ref_id = $request['freeform_report'];
            $freeform_report = FreeFormReport::whereIn('ref_id', $ff_ref_id);
            $flag = $freeform_report->update(['archive' => 0]);
        }

        if(array_key_exists('external_report',$request)){
            $exr_ref_id = $request['external_report'];
            $external_report = ExternalReport::whereIn('external_report', $exr_ref_id);
            $flag = $external_report->update(['archive' => 0]);
        }

        if(array_key_exists('video_report',$request)){
            $exr_ref_id = $request['video_report'];
            $video_report = VideoReport::whereIn('video_report', $exr_ref_id);
            $flag = $video_report->update(['archive' => 0]);
        }

        if(array_key_exists('alerts',$request)){
            $alert_ref_id = $request['alerts'];
            $alert = Alert::whereIn('ref_id', $alert_ref_id);
            $flag = $alert->update(['archive' => 0]);
        }

        if(array_key_exists('semi_automatic_report',$request)){
            $semi_automatic_ref_id = $request['semi_automatic_report'];
            $semi_automatic_report = SemiAutomatic::whereIn('ref_id', $semi_automatic_ref_id);
            $flag = $semi_automatic_report->update(['archive' => 0]);
        }

        if(array_key_exists('fully_manual',$request)){
            $fully_manual_ref_id = $request['fully_manual'];
            $fully_manual_report = FullyManual::whereIn('ref_id', $fully_manual_ref_id);
            $flag = $fully_manual_report->update(['archive' => 0]);
        }

        if($flag){ 
            return response()->json([
                'status'=> 'Success',
                'message' => 'Reports unarchived successfully'
            ], 200);
        }else{
            return response()->json('Error - while unarchiving reports',302);
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
     * institutional_report_search
     *
     * @param  mixed $institution_report
     * @param  mixed $request
     * @return void
     */
    private function institutional_report_search($institution_report, $request){
        if(auth()->user()->hasRole('Analyst')){
            $institution_report->own();
        }
        if($request->has('analysts') || $request->has('from_date') || $request->has('to_date') || $request->has('search_title') || $request->has('search_ref_id'))
        {
            if($request['analysts'] != ""){
                $institution_report->whereHas('tasks', function($query) use ($request){ 
                    $query->whereHas('latest_task_log',  function($q) use ($request){  
                        $q->where('assigned_to', $request['analysts']);
                    });
                });
            }

            if($request['from_date'] != ""){
                $date = Carbon::parse($request['from_date'],auth()->user()->timezone)->setTimezone('utc');
                $institution_report->where('date_time', '>=', $date);
            }
                
            if($request['to_date'] != ""){
                $date = Carbon::parse($request['to_date'], auth()->user()->timezone)->setTimezone('UTC')->addDay(1);
                $institution_report->where('date_time', '<=', $date);
            }

            if($request['search_title'] != ""){
                $institution_report->where('name', 'like', '%'.$request['search_title'].'%');
            }

            if($request['search_ref_id'] != ""){
                $institution_report->where('institution_report', 'like', '%'.$request['search_ref_id'].'%');
            }
                
        }else if($request['default_from_date'] != "" && $request['default_to_date'] != ""){
            $default_from_date = Carbon::parse($request['default_from_date'],auth()->user()->timezone)->setTimezone('utc');
            $default_to_date = Carbon::parse($request['default_to_date'], auth()->user()->timezone)->setTimezone('UTC')->addDay(1);
            $institution_report->where('date_time', '>=', $default_from_date);
            $institution_report->where('date_time', '<=', $default_to_date);
            
        }
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

            if($request['search_title'] != ""){
                $freeform_report->where('title', 'like', '%'.$request['search_title'].'%');
            }

            if($request['search_ref_id'] != ""){
                $freeform_report->where('ref_id', 'like', '%'.$request['search_ref_id'].'%');
            }
                
        }else if($request['default_from_date'] != "" && $request['default_to_date'] != ""){
            $default_from_date = Carbon::parse($request['default_from_date'],auth()->user()->timezone)->setTimezone('utc');
            $freeform_report->where('date_time', '>=', $default_from_date);
            $default_to_date = Carbon::parse($request['default_to_date'], auth()->user()->timezone)->setTimezone('UTC')->addDay(1);
            $freeform_report->where('date_time', '<=', $default_to_date);
        }
    }
    
    /**
     * institutional_report_search
     *
     * @param  mixed $institution_report
     * @param  mixed $request
     * @return void
     */
    private function alert_search($alert, $request){
        if(auth()->user()->hasRole('Analyst')){
            $alert->own();
        }

        if($request->has('analysts') || $request->has('from_date') || $request->has('to_date') || $request->has('search_title') || $request->has('search_ref_id'))
        {
            if($request['analysts'] != ""){
                $alert->whereHas('tasks', function($query) use ($request){ 
                    $query->whereHas('latest_task_log',  function($q) use ($request){  
                        $q->where('assigned_to', $request['analysts']);
                    });
                });
            }

            if($request['from_date'] != ""){
                $date = Carbon::parse($request['from_date'],auth()->user()->timezone)->setTimezone('utc');
                $alert->where('created_at', '>=', $date);
            }
                
            if($request['to_date'] != ""){
                $date = Carbon::parse($request['to_date'], auth()->user()->timezone)->setTimezone('UTC')->addDay(1);
                $alert->where('created_at', '<=', $date);
            }

            if($request['search_title'] != ""){
                $alert->where('title', 'like', '%'.$request['search_title'].'%');
            }

            if($request['search_ref_id'] != ""){
                $alert->where('ref_id', 'like', '%'.$request['search_ref_id'].'%');
            }
                
        }else if($request['default_from_date'] != "" && $request['default_to_date'] != ""){
            $default_from_date = Carbon::parse($request['default_from_date'],auth()->user()->timezone)->setTimezone('utc');
            $alert->where('created_at', '>=', $default_from_date);
            $default_to_date = Carbon::parse($request['default_to_date'], auth()->user()->timezone)->setTimezone('UTC')->addDay(1);
            $alert->where('created_at', '<=', $default_to_date);
        }
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
}
