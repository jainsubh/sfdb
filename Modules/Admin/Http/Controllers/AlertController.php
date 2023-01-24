<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Datatables;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use App\Authorizable;
use App\Alert;
use App\Sectors;
use App\Event;
Use App\InstitutionReport;
use App\User;
use App\AlertComments;
use App\AlertKeywords;
use App\AlertCountry;
use App\Tasks;
use App\AlertGallery;
use App\Dataset;
Use Auth;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use PDF;

class AlertController extends Controller
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
        $datasets = $this->datasets;
        return view('admin::alerts.index', compact('datasets'));
    }

    /**
     * Return datatable format json for user listing
     * @return json
     */
    public function datatable(Request $request){   
        if ($request->ajax()) {
            //DB::enableQueryLog(); // Enable query log
            $alerts = Alert::doesnthave('tasks')->active()->latest('id');
            //dd(DB::getQueryLog()); // Show results of log
            return Datatables::of($alerts)
            ->editColumn('date_time', function ($alerts) {
                return Carbon::parse($alerts->created_at, 'UTC')->setTimezone(auth()->user()->timezone);
            })
            ->make(true); 
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(){
        return view('admin::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request){
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id, Request $request){
        
        try
        {
            $alert = Alert::with(['tasks.semi_automatic', 'tasks.latest_task_log', 'tasks.fully_manual','tasks.product', 'keywords', 'links', 'tweets', 'sectors', 'events.eventdepartments.departments', 'events.users:id,name','events.created_by_user', 'comments.users','countries.country'])->where('id', $id)->firstOrFail();
            if($alert->events == null){
                return response()->json('Could not open the alert, event for this alert has been deleted', 500);
            }
            if(auth()->user()->hasRole('Analyst') && $this->checkAnalystExist($alert->event_id)){
                return response()->json('Analyst has been removed from this event', 500);
            }

            if(auth()->user()->hasRole('Analyst') && $alert->tasks && $alert->tasks->latest_task_log && Auth::id() != $alert->tasks->latest_task_log->assigned_to){
                return response()->json('Analyst has been removed from this alert', 500);
            }
            
            $analysts = array();
            $analysts_users = array();
            $analysts_created = array();
            $supervisor = array();

            if(isset($alert->events->users) && $alert->events->users->count() > 0){
                $analysts_users = $alert->events->users->pluck('name', 'id')->toArray();
            }

            if(Auth::user()->hasRole('Supervisor')){
                $supervisor = User::with('roles')->role(['Supervisor'])->pluck('name', 'id')->toArray();
            }
            
            /*
            if($alert->events->created_by_user && $alert->events->created_by_user->hasRole('Analyst')){
                $analysts_created = $alert->events->created_by_user->pluck('name', 'id')->toArray();
            }
            */

            $totalAnalyts = $analysts_users + $supervisor;
            //$totalAnalyts = $analysts_users + $analysts_created +$supervisor;
           
            $analysts = array_unique($totalAnalyts);
        }
        catch(ModelNotFoundException $e)
        {
            if($request->ajax()) {
                return response()->json('Alert for this task has been deleted', 302);
            }
            else{
                abort(404);
            }
        }
        if($request->ajax()) {
            return view('alerts.show',compact(['alert','analysts']))->render(); 
        }
        else{
            $datasets = $this->datasets;
            return view('alerts.index',compact(['alert','analysts', 'datasets']))->with('name','Event-Alert');
        }
    }

    /**
     * Show pdf template of System generated report
     */
    public function automatic_template($id, Request $request){
        try{
            $datasets = $this->datasets;
            $alert = Alert::with(['gallery', 'tasks.semi_automatic', 'tasks.latest_task_log', 'tasks.fully_manual', 'keywords', 'links', 'tweets', 'sectors', 'events.eventdepartments.departments', 'comments.users','countries.country'])->where('id', $id)->firstOrFail();
            $keywords  = $alert->keywords->pluck('keyword')->toArray();
            $links  = $alert->links->pluck('url')->take(5)->toArray();
        }
        catch(ModelNotFoundException $e){
            abort(404);
        }
        return view('report_template.automatic', compact('alert', 'keywords', 'links', 'datasets'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id){
        $datasets = $this->datasets;
        $alert = Alert::with(['keywords', 'links', 'tweets', 'sectors', 'events.eventdepartments.departments', 'comments.users','countries.country'])->where('id', $id)->firstOrFail();
        return view('admin::alerts.edit', compact('alert', 'datasets'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id){
        $alert = Alert::findOrFail($id);
        /*if($request->hasFile('file')){
            $validator = Validator::make($request->all(), [
                'file' => 'required|image|mimes:jpeg,png,jpg',
            ]);
            
            if ($validator->fails()){
                return response()->json($validator->errors()->first(), 302);
            }

            $image      = $request->file;
            $fileName   = time().'_'.$image->getClientOriginalName();
            if($image->storeAs('system_generated_report/photos', $fileName)){
                $alert->gallery()->save(new AlertGallery(['images' => $fileName]));
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Images added successfully',
                'data' => $alert->gallery->last()
            ], 200);
        }else{*/
            if($alert->update($request->all())){
                return response()->json([
                    'status' => 'success',
                    'message' => 'Alert data save successfully',
                    'data' => $alert
                ], 200);
            }
        /*}*/
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id){
        //
    }

    /**
     * Archive Alerts
     * @param int $id
     * @return Renderable
     */
    public function archive($id){
        $alert = Alert::where('id', $id)->firstOrFail();
        if($alert->archive == 1){
            return response()->json([
                'status'=>'Error',
                'message' => 'Alert already archived',
                'data' => $alert
            ], 409);
        }else{
            $alert->archive = 1;
            if($alert->save()){
                return response()->json([
                    'status'=>'Success',
                    'message' => 'Alert archived successfully',
                    'data' => $alert
                ], 200);
            }else{
                return response()->json([
                    'status'=>'Error',
                    'message' => 'Error - while archiving alert',
                    'data' => $alert
                ], 500);
            }
        }
    } 
        
    /**
     * archive
     *
     * @param  mixed $id
     * @return void
     */
    public function unarchive($id){
        $alert = Alert::where('id', $id)->firstOrFail();
        if($alert->archive == 0){
            return response()->json([
                'status'=>'Error',
                'message' => 'Alert already unarchived'
            ], 409);
        }else{
            $alert->archive = 0;
            if($alert->save()){
                return response()->json([
                    'status'=>'Success',
                    'message' => 'Alert unarchived successfully'
                ], 200);
            }else{
                return response()->json([
                    'status'=>'Error',
                    'message' => 'Error - while unarchiving alert'
                ], 500);
            }
        }
    }
    
    /**
     * comment
     *
     * @param  mixed $request
     * @return void
     */
    public function comment(Request $request){

        $validator = Validator::make($request->all(), [
            'comments' => 'required',
        ]);

        if(!$validator->fails()){
            $alert = Alert::with('events')->findorFail($request['alert_id']);
            if($alert->events == null){
                return response()->json('Not able to publish comment, event for this alert has been deleted', 500);
            }
            else{
                $alertComment = [
                    'comments' => $request['comments'],
                    'user_id' => auth()->user()->id,
                    'alert_id' => $request['alert_id']
                ];
                if(AlertComments::create($alertComment)){
                    
                    $data = '<div class="txt white"><p><span class="comment_user blue">'.auth()->user()->name.
                    '</span><span class="comment_date red">'.
                    \Carbon\Carbon::parse(now(), 'UTC')->timezone(auth()->user()->timezone)->isoFormat('lll').
                    '</span></p><p>'.$alertComment["comments"].
                    '</p><hr class="mg-10"></div>';

                    return response()->json([
                        'status' => 'success',
                        'message' => 'Comment added successfully',
                        'data' => $data
                    ], 200);
                }else{
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Failed to add a comment'
                    ], 500);
                }
            }
        }
        else{
            return response()->json([
                'status' => 'error',
                'message' => 'Please check your validation'
            ], 500);
        }
    }

    public function countries($id){
        $countries = AlertCountry::where('alert_id', $id)->with(['country'])->get();
        return $countries->map(function ($value) {
            return [
                    'title' => $value->country->country_name, 
                    'city' => $value->country->city, 
                    'latitude' => $value->country->latitude,
                    'longitude' => $value->country->longitude,
                    'tooltip_description' => $value->country->city,
                    'color' => 'yellow'
                ];
        });
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function complete(Request $request, $id){
        $alert = Alert::with(['gallery', 'tasks.semi_automatic', 'tasks.latest_task_log', 'tasks.fully_manual', 'keywords', 'links', 'tweets', 'sectors', 'events.eventdepartments.departments', 'comments.users','countries.country'])->where('id', $id)->firstOrFail();
        $keywords  = $alert->keywords->pluck('keyword')->toArray();
        $links  = $alert->links->pluck('url')->toArray();

        $pdf = PDF::loadHTML(view('report_template.automatic', compact('alert', 'keywords', 'links')));
        $pdf->save(storage_path('app/system_generated_report/'.$alert->ref_id.'.pdf'), $overwrite = true);

        flash('Alert completed successfully')->success();
        return redirect()->route('alerts.index');    
    }
        
    /**
     * latest_alert
     *
     * @return void
     */
    public function latest_alert(Request $request){
        $alerts = [];
        $alerts = Alert::doesnthave('tasks')->active()->where('id','>', $request['id'])->latest('id')->get();
        $latest_id = $alerts->pluck('id')->first();
        return response()->json(['success' => true ,'html' => view('alerts.alert_card', compact('alerts'))->render(), 'latest_id'=>$latest_id]);
    }
    
    /**
     * latest_alert
     *
     * @param  mixed $request
     * @return void
     */
    public function event_alert(Request $request){
        $alerts = Alert::doesnthave('tasks')->active()->where('event_id', $request['event_id'])->latest('id')->paginate();
        $alerts_title = Alert::doesnthave('tasks')->active()->where('event_id', $request['event_id'])->latest('id')->pluck('title')->toArray();
        $alerts->withPath(route('alerts.paginate_alert', ['event_id' => $request['event_id']]));
        $with_pagination = 1;
        $latest_id = $alerts->pluck('id')->first();
        return response()->json(['success' => true ,
                                'html' => view('alerts.alert_card', compact('alerts', 'with_pagination'))->render(), 
                                'latest_id'=>$latest_id,
                                'alerts_title' => $alerts_title
                                ]);
    }

    /**
     * latest_alert with pagination
     *
     * @return void
     */
    public function paginate_alert(Request $request){
        $alerts = Alert::doesnthave('tasks')->active()->where('event_id', $request['event_id'])->latest('id')->paginate(15);
        $with_pagination = 1;
        return view('alerts.alert_card', compact('alerts', 'with_pagination'))->render();
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function download($filename, $filetype = 'pdf')
    {
        $filepath = 'system_generated_report/'.$filename.'.'.$filetype;
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

    public function knowledgeMap($alert_id){
        $keywords = AlertKeywords::where('alert_id', $alert_id)->latest('id')->limit(10)->get()->map(function ($item) {
            return [
                  'id' => $item->keyword, // use the appropriate variable here 
                  'children' => [],
                  'collapsed' =>  true
            ];
        });
        return ['id' => 'Event Map', 'children' => $keywords];
    }

    /**
     * bulk_archive
     *
     * @param  mixed $id
     * @return void
     */
    public function bulk_archive(Request $request)
    {
        parse_str($request->input('data'), $request);
        
        $ref_id = $request['alerts'];
        $alert = Alert::whereIn('ref_id', $ref_id);
        
        if($alert->update(['archive' => 1])) {
            return response()->json([
                'status'=>'Success',
                'message' => 'System generated alert archived successfully',
                'data' => $alert
            ], 200);
        }
        else{
            return response()->json('Error - while archiving system generated alert',302);
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
        
        $ref_id = $request['alerts'];
        $alert = Alert::whereIn('ref_id', $ref_id);
        
        if($alert->delete()) {
            return response()->json([
                'status'=>'Success',
                'message' => 'System generated alert deleted successfully',
                'data' => $alert
            ], 200);
        }
        else{
            return response()->json('Error - while deleting system generated alert',302);
        }
        
    }

    private function checkAnalystExist($id){
        $assigned_analyst = Event::with(['eventuser'])->where('id', $id)->active()->first();
        $total_analyst = $assigned_analyst->eventuser->pluck('user_id')->toArray();
        if($assigned_analyst->created_by_user){
            $assigned_analyst = $assigned_analyst->created_by_user->id;
            array_push($total_analyst, $assigned_analyst);
        }
        if(!in_array(auth()->user()->id, $total_analyst))
            return true;
        else 
            return false;
    }
}
