<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Activitylog\Models\Activity;
use Carbon\Carbon;
use App\Alert;
use App\Product;
use App\Event;
use Auth;
use App\Tasks;
use App\Authorizable;
Use App\ExternalReport;
Use App\InstitutionReport;
use DB;

class AnalystController extends Controller
{
    use Authorizable;
    /**s
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $institution_report = InstitutionReport::doesnthave('tasks')->active()->latest('id')->paginate(10);
        $institution_report->withPath(route('institution_report.paginate_institution_report'));

        //$alerts = Alert::doesnthave('tasks')->active()->latest('id')->paginate(10);
        //$alerts->withPath(route('alerts.paginate_alert'));
        $alerts = [];

        $events = Event::own()->with(['sectors','created_by_user','eventuser'])->active()->latest('id')->get();
        //dd($events[0]->eventuser);
        $tasks = Tasks::own()->inProgress()->latestTask('created')->with(['subject', 'latest_task_log.assigned_to_user', 'latest_task_log.assigned_by_user'])->whereHasMorph('subject',['App\Tasks', 'App\InstitutionReport', 'App\FreeFormReport', 'App\ExternalReport', 'App\Alert'])->latest('updated_at')->get();
        
        //Retreiving latest new tasks that are have been completed
        $tasks_completed = Tasks::own()->complete()->with(['subject', 'latest_task_log.assigned_to_user', 'latest_task_log.assigned_by_user', 'semi_automatic', 'fully_manual', 'product'])->whereHasMorph('subject',['App\Tasks', 'App\InstitutionReport', 'App\ExternalReport', 'App\FreeFormReport', 'App\Product','App\Alert'])->latest('updated_at')->get();
       
        $activities = Activity::with('subject', 'subject.latest_task_log')->where(['log_name' => 'tasks_log', 'properties->assigned_to' => auth()->user()->id])->latest()->get();
        //dd($activities[0]);
        return view('analyst', compact(['institution_report', 'events','alerts', 'tasks', 'tasks_completed', 'activities']))->with('name','Analyst Dashboard');
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
}
