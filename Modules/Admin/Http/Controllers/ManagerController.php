<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage; 
use Spatie\Activitylog\Models\Activity;
use Auth;
use App\Authorizable;
use App\Alert;
use App\Event;
use App\Sectors;
use App\Tasks;
use App\Departments;
Use App\InstitutionReport;
Use App\ExternalReport;
Use App\Product;
use App\User;
use DB;
use Carbon\Carbon;

class ManagerController extends Controller
{
    use Authorizable;

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(){
        //DB::enableQueryLog(); // Enable query log
        //dd(DB::getQueryLog()); // Show results of log

        //Retrieving institution reports to show on manager dashboard
        $institution_report = InstitutionReport::doesnthave('tasks')->active()->latest('id')->paginate(6);
        $institution_report->withPath(route('institution_report.paginate_institution_report'));
        //Showing alerts on manager dashboard
        //$alerts = Alert::doesnthave('tasks')->active()->latest('id')->paginate(15);
        //$alerts->withPath(route('alerts.paginate_alert'));
        $alerts = [];

        //Showing events on manager dashboard
        $events = Event::with(['sectors','created_by_user'])->active()->latest('id')->get();
        
        //Retreiving latest new tasks that are in progress yet
        $tasks = Tasks::inProgress()->latestTask('created')->with(['subject', 'latest_task_log.assigned_to_user', 'latest_task_log.assigned_by_user'])->whereHasMorph('subject',['App\Tasks', 'App\InstitutionReport','App\ExternalReport', 'App\FreeFormReport','App\Alert'])->latest('updated_at')->get();
        
        //Retrieve all transfer request
        $task_transfer = Tasks::latestTask('transfer')->with(['subject', 'latest_task_log.assigned_to_user', 'latest_task_log.assigned_by_user'])->whereHasMorph('subject',['App\Tasks', 'App\InstitutionReport', 'App\ExternalReport', 'App\FreeFormReport','App\Alert'])->latest('tasks.updated_at')->get();
        
        //Retreiving latest new tasks that are have been completed
        $tasks_completed = Tasks::complete()->with(['subject', 'latest_task_log.assigned_to_user', 'latest_task_log.assigned_by_user', 'semi_automatic', 'fully_manual', 'product', 'completed_by_user'])->whereHasMorph('subject',['App\Tasks', 'App\InstitutionReport', 'App\ExternalReport', 'App\FreeFormReport', 'App\Product','App\Alert'])->latest('updated_at')->get();
        
        $analysts = User::role(['Analyst', 'Supervisor'])->pluck('name', 'id')->toArray();

        $activities = Activity::where('log_name', 'tasks_log')->latest()->get();

        if(Auth::user()->hasRole('Supervisor')){
            $name = 'Supervisor Dashboard';
        }else{
            $name = 'Manager Dashboard';
        }

        return view('manager.index', compact('alerts', 'institution_report', 'events', 'tasks', 'task_transfer', 'tasks_completed', 'analysts', 'activities'))->with('name', $name);  
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(){
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function download($filename)
    {
        $filepath = 'semi-automatic/'.$filename.'.pdf';
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

    public function view_as_analyst(Request $request){
        //Events
        $events = Event::viewAs($request['analysts'])->with(['sectors','created_by_user','eventuser'])->active()->latest('id')->get();

        //In Progress
        $tasks = Tasks::viewAs($request['analysts'])->inProgress()->latestTask('created')->with(['subject', 'latest_task_log.assigned_to_user', 'latest_task_log.assigned_by_user'])->whereHasMorph('subject',['App\Tasks', 'App\InstitutionReport','App\ExternalReport', 'App\FreeFormReport','App\Alert'])->latest('updated_at')->get();
        
        //Retreiving latest new tasks that are have been completed
        $tasks_completed = Tasks::viewAs($request['analysts'])->complete()->with(['subject', 'latest_task_log.assigned_to_user', 'latest_task_log.assigned_by_user', 'semi_automatic', 'fully_manual', 'product', 'completed_by_user'])->whereHasMorph('subject',['App\Tasks', 'App\InstitutionReport', 'App\ExternalReport', 'App\FreeFormReport', 'App\Product','App\Alert'])->latest('updated_at')->get();
        
        //$latest_event_id = $events->pluck('id')->first();
        $analyst_name = User::where('id', $request['analysts'])->pluck('name')->first();
        
        return response()->json(
            ['success' => true ,
            'html' => [view('admin::events.event_card', compact('events'))->render(), 
                       view('tasks.inprogress_card', compact('tasks'))->render(),
                       view('tasks.team_report_card', compact('tasks_completed'))->render()
                    ], 
            /*'latest_event_id'=>$latest_event_id,*/ 
            'view_as_analyst'=>$analyst_name]);
    }

}
