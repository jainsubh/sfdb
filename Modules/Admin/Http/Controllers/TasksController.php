<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Database\Eloquent\Builder;
Use Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Tasks;
use App\Alert;
use App\Event;
use App\InstitutionReport;
use App\ExternalReport;
use App\User;
use App\Tasklog;
use App\Authorizable;
use Mail;
use Yajra\Datatables\Datatables;
use Spatie\Activitylog\Models\Activity;
use App\Mail\DataSent;
use App\Dataset;

class TasksController extends Controller
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
    public function index(Request $request)
    {
        if($request->ajax()){
            if(auth()->user()->hasRole('Manager') || auth()->user()->hasRole('Supervisor')){
                $tasks = Tasks::with(['subject', 'semi_automatic', 'fully_manual', 'latest_task_log.assigned_to_user', 'latest_task_log.assigned_by_user'])->where('status','!=','complete')->latest('tasks.due_date')->get();
            }
            else if(auth()->user()->hasRole('Analyst')){
                $tasks = Tasks::own()->with(['subject', 'semi_automatic', 'fully_manual', 'latest_task_log.assigned_to_user', 'latest_task_log.assigned_by_user'])->where('status','!=','complete')->latest('tasks.due_date')->get();
            }
            return view('tasks.task_reminder',compact('tasks'));
        }
        else{
            $datasets = $this->datasets;
            return view('admin::tasks.index', compact('datasets'));
        }
    }

    /**
     * Return datatable format json for user listing
     * @return json
     */

    public function datatable()
    {   
        if(auth()->user()->hasRole('Analyst')){
            $tasks = Tasks::own()->with(['subject', 'semi_automatic', 'fully_manual', 'latest_task_log.assigned_to_user', 'latest_task_log.assigned_by_user'])
            ->whereHasMorph('subject',['App\Tasks', 'App\InstitutionReport', 'App\FreeFormReport','App\ExternalReport','App\Alert']);
            //->latest('due_date');
        }
        else{
            $tasks = Tasks::with(['subject', 'semi_automatic', 'fully_manual', 'latest_task_log.assigned_to_user', 'latest_task_log.assigned_by_user'])
            ->whereHasMorph('subject',['App\Tasks', 'App\InstitutionReport', 'App\FreeFormReport','App\ExternalReport','App\Alert']);
            //->latest('due_date');
        }

        return Datatables::of($tasks)
        /*->addColumn('priority_raw', function ($tasks) {
            if($tasks->priority == 'low'){
                return '<span class="badge badge-success m-2">'.ucfirst($tasks->priority).'</span>';
            }elseif($tasks->priority == 'medium'){
                return '<span class="badge badge-warning m-2">'.ucfirst($tasks->priority).'</span>';
            }else{
                return '<span class="badge badge-danger m-2">'.ucfirst($tasks->priority).'</span>';
            }
        })->rawColumns(['priority_raw'])*/
        ->editColumn('title', function ($tasks) {
            if($tasks->subject_type == "alert"){
                return $tasks->alert->title ? with(Str::limit($tasks->alert->title, 80)) : '';
            }elseif($tasks->subject_type == "freeform_report"){
                return $tasks->subject->title ? with(Str::limit($tasks->subject->title, 80)) : '';
            }elseif($tasks->subject_type == "institution_report"){
                return $tasks->report->name ? with(Str::limit($tasks->report->name, 80)) : '';
            }elseif($tasks->subject_type == "external_report"){
                return $tasks->external_report->title ? with(Str::limit($tasks->external_report->title, 80)) : '';
            }
        })
        ->editColumn('due_date', function ($tasks) {
            return Carbon::parse($tasks->due_date)->isoFormat('ll');
        })->editColumn('created_at', function ($tasks) {
            return Carbon::parse($tasks->created_at, 'UTC')->setTimezone(auth()->user()->timezone);
        })->editColumn('updated_at', function ($tasks) {
            // if($tasks->subject_type == "freeform_report"){
            //     return Carbon::parse($tasks->subject->updated_at, 'UTC')->setTimezone(auth()->user()->timezone); 
            // }else{
            //     return Carbon::parse($tasks->updated_at, 'UTC')->setTimezone(auth()->user()->timezone); 
            // }
            return Carbon::parse($tasks->updated_at, 'UTC')->setTimezone(auth()->user()->timezone);
        })->editColumn('completed_at', function ($tasks) {
            if($tasks->completed_at != null)
                return Carbon::parse($tasks->completed_at, 'UTC')->setTimezone(auth()->user()->timezone);
            else 
                return null;

        })->make(true);
        
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('admin::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $messages = [
            'analysts.required' => 'Any analyst should be selected before assignment'
        ];
        
        if(Auth::user()->hasRole('Analyst')){
            $validator = Validator::make($request->all(), [
                'due_date' => 'required',
                'priority' => 'required'
            ], $messages);

            $request['analysts'] = auth()->user()->id;
        }
        else{
            $validator = Validator::make($request->all(), [
                'analysts' => 'required',
                'due_date' => 'required',
                'priority' => 'required'
            ], $messages);
        }
        if( !$validator->fails()){
            if($request['request_type'] == 'reassign'){
                $task = Tasks::findOrFail($request['task_id']);

                $task->priority = $request['priority'];
                $task->due_date = $request['due_date'];
                $task->status = 'new';

                if($request['type'] == 'institutional_report'){
                    $task->subject_id = $request['report_id'];
                    $task->subject_type = 'institution_report';
                }elseif($request['type'] == 'external_report'){
                    $task->subject_id = $request['report_id'];
                    $task->subject_type = 'external_report';
                }else if($request['type'] == 'freeform_report'){
                    $task->subject_id = $request['freeform_report_id'];
                    $task->subject_type = 'freeform_report';
                }else{
                    $task->subject_id = $request['alert_id'];
                    $task->subject_type = 'alert';
                }

                if($task->save()){
                    $task_log = [
                        'description' => 'created',
                        'task_id' => $task->id,
                        'assigned_to' => $request['analysts'],
                        'assigned_by' => auth()->user()->id
                    ];
                }else{
                    return response()->json('Failed to assign task to anyone', 302);
                }
            }else{ //New Task Create
                $task = [
                    'priority' => $request['priority'],
                    'due_date' => $request['due_date'],
                    'status' => 'new',
                ];
    
                if($request['type'] == 'institutional_report'){
                    $report = InstitutionReport::findOrFail($request['report_id']);
                    if(!isset($report->tasks->subject_id))
                        $task = $report->tasks()->create($task);
                    else
                        return response()->json('Task has already been created', 302);
                }elseif($request['type'] == 'external_report'){
                    $report = ExternalReport::findOrFail($request['report_id']);
                    if(!isset($report->tasks->subject_id))
                        $task = $report->tasks()->create($task);
                    else
                        return response()->json('Task has already been created', 302);
                }else{
                    $alert = Alert::with('events')->findOrFail($request['alert_id']);
                    if($alert->events == null){
                        return response()->json('Could not assign task, event for this alert has been deleted', 500);
                    }
                    if(auth()->user()->hasRole('Analyst') && $this->checkAnalystExist($alert->event_id)){
                        return response()->json('Could not assign task, Analyst has been removed from this alert', 500);
                    }
                    if(!isset($alert->tasks->subject_id))
                        $task = $alert->tasks()->create($task);
                    else
                        return response()->json('Task has already been created', 302);
                }
                
                if($task){
                    $task_log = [
                        'description' => 'created',
                        'task_id' => $task->id,
                        'assigned_to' => $request['analysts'],
                        'assigned_by' => auth()->user()->id
                    ];
                }else{
                    return response()->json('Failed to create task', 302);
                }
            }
            
            //Save Activity
            if($request['request_type'] != 'reassign'){
                if(auth()->user()->id  == $request['analysts']){
                    $log = 'self_assign';
                }else{
                    $log = 'assign';
                }
            }else{
                $log = 'transfered';
            }

            $userModel = User::findOrFail(auth()->user()->id);
            $assignedUser = User::where('id', $request['analysts'])->firstOrFail();
            
            activity('tasks_log')
                ->causedBy($userModel)
                ->performedOn($task)
                ->withProperties(['assigned_to' => $assignedUser->id, 'assigned_to_name' => $assignedUser->name])
                ->log($log);

            if(Tasklog::Create($task_log)){
                $task = Tasks::with(['subject', 'latest_task_log.assigned_to_user', 'latest_task_log.assigned_by_user'])->findOrFail($task->id);
                
                $data = array(
                    'from_email' => $task->latest_task_log->assigned_by_user->email,
                    'from_name' => $task->latest_task_log->assigned_by_user->name,
                    'subject' => 'Task Assigned',
                    'view' => 'tasks.assign_email_temp',
                    'data' => $task,
                    'timezone' => auth()->user()->timezone,
                    'auth_name' => auth()->user()->name
                );

                Mail::to($task->latest_task_log->assigned_to_user->email, $task->latest_task_log->assigned_to_user->name)->queue(new DataSent($data));

                return response()->json([
                    'status'=>'Success',
                    'message' => 'Task Created successfully',
                    'data' => $task,
                    'task_card' => view('tasks.card',compact(['task']))->render()
                ], 200);
            }else{
                return response()->json('Task has not been assigned to anyone yet', 302);
            }
        }else{
            return response()->json($validator->errors()->first(), 302);
        }
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
        //
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
     * transfer
     *
     * @param  mixed $request
     * @return void
     */
    public function transfer(Request $request){
        $validator = Validator::make($request->all(), [
            'task_id' => 'required'
        ]);

        if(!$validator->fails()){
            $task = Tasks::with(['latest_task_log','latest_task_log.assigned_to_user'])->find($request->task_id);
            
            if($task->latest_task_log->description == 'created'){
                $task->status = 'pending';
                if($task->save()){

                    //Save Activity
                    $userModel = User::where('id', $task->latest_task_log->assigned_to)->firstOrFail();
            
                    activity('tasks_log')
                        ->causedBy($userModel)
                        ->performedOn($task)
                        ->withProperties(['assigned_to' => $task->latest_task_log->assigned_to, 'assigned_to_name' => $userModel->name])
                        ->log('transfer_request');

                    $task_log = [
                        'description' => 'transfer',
                        'task_id' => $task->id,
                        'assigned_to' => $task->latest_task_log->assigned_to,
                        'assigned_by' => auth()->user()->id
                    ];
    
                    if(Tasklog::Create($task_log)){
                        $task = Tasks::with(['subject','latest_task_log','latest_task_log.assigned_to_user', 'latest_task_log.assigned_by_user'])->find($request->task_id);
                        $manager_emails = User::role('Manager')->pluck('email','name')->toArray();
                        
                        $data = array(
                            'from_email' => $task->latest_task_log->assigned_by_user->email,
                            'from_name' => $task->latest_task_log->assigned_by_user->name,
                            'subject' => 'Task Transfer Request',
                            'view' => 'tasks.transfer_email_temp',
                            'data' => $task,
                            'timezone' => auth()->user()->timezone,
                            'auth_name' => auth()->user()->name
                        );

                        Mail::to(array_values($manager_emails), array_keys($manager_emails))->queue(new DataSent($data));
        
                        return response()->json([
                            'status' => 'Success',
                            'message' => 'Transfer request send successfully',
                            'data' => $task
                        ], 200);
                    }
                }
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error in transfer request to Manager'
                ], 500);
            }
            
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function complete(Request $request, $id){
        $tasks = Tasks::with(['subject', 'semi_automatic', 'fully_manual', 'latest_task_log.assigned_to_user', 'latest_task_log.assigned_by_user', 'completed_by_user'])->findOrFail($id);
        
        $tasks->status = 'complete';
        $tasks->completed_at = Carbon::now();
        $tasks->completed_by = auth()->user()->id;
        if($tasks->save()){

            //Save Activity
            $userModel = User::where('id', auth()->user()->id)->firstOrFail();
            
            activity('tasks_log')
                ->causedBy($userModel)
                ->performedOn($tasks)
                ->withProperties(['assigned_to' => $tasks->latest_task_log->assigned_to, 'assigned_to_name' => $tasks->latest_task_log->assigned_to_user->name])
                ->log('completed');

            //Sending Mail if task is completed
            $manager_emails = User::role('Manager')->pluck('email','name')->toArray();
            
            $data = array(
                'from_email' => $tasks->latest_task_log->assigned_to_user->email,
                'from_name' => $tasks->latest_task_log->assigned_to_user->name,
                'subject' => 'Task Completed',
                'view' => 'tasks.complete_email_temp',
                'data' => $tasks,
                'timezone' => auth()->user()->timezone,
                'auth_name' => auth()->user()->name
            );

            Mail::to(array_values($manager_emails), array_keys($manager_emails))->queue(new DataSent($data));

            if($tasks->priority == 'low'){
                $tasks->priority = '<span class="badge badge-success m-2">'.ucfirst($tasks->priority).'</span>';
            }elseif($tasks->priority == 'medium'){
                $tasks->priority = '<span class="badge badge-warning m-2">'.ucfirst($tasks->priority).'</span>';
            }else{
                $tasks->priority = '<span class="badge badge-danger m-2">'.ucfirst($tasks->priority).'</span>';
            }
            if($tasks->subject_type == "alert" || $tasks->subject_type == "freeform_report" || $tasks->subject_type == "external_report"){
                $tasks->title = str::limit($tasks->subject->title, 80);
            }else{
                $tasks->title = str::limit($tasks->subject->name, 80);
            }
            
            $tasks->due_date = Carbon::parse($tasks->due_date)->isoFormat('ll');

            return response()->json([
                'status' => 'success',
                'message' => 'Task completed successfully',
                'data' => $tasks,
            ], 200);
        }else {
            return response()->json([
                'status' => 'error',
                'message' => 'Error while complete task',
            ], 500);
        }
    }

    public function reopen(Request $request, $id){
        $task = Tasks::with(['subject', 'semi_automatic', 'fully_manual', 'product', 'latest_task_log.assigned_to_user', 'latest_task_log.assigned_by_user', 'completed_by_user'])->findOrFail($id);
        
        $task->status = 'new';
        $task->completed_at = null;
        $task->completed_by = null;

        if($task->save()){

            if($task->semi_automatic){
                $task->semi_automatic->update(['status' => 'progress']);
            }    
            if($task->fully_manual){
                $task->fully_manual->update(['status' => 'progress']);
            }
            if($task->product){
                $task->product->update(['status' => 'progress']);
            }

            $userModel = User::where('id', auth()->user()->id)->firstOrFail();
            activity('tasks_log')
                ->causedBy($userModel)
                ->performedOn($task)
                ->withProperties(['assigned_to' => $task->latest_task_log->assigned_to, 'assigned_to_name' => $task->latest_task_log->assigned_to_user->name])
                ->log('reopen');

            return response()->json([
                    'status' => 'success',
                    'message' => 'Task completed successfully',
                    'data' => $task,
                    'task_card' => view('tasks.card',compact(['task']))->render()
                ], 200);
        }else {
            return response()->json([
                'status' => 'error',
                'message' => 'Error while re-open this task',
            ], 500);
        }
    }
    
    /**
     * latest_inprogress
     *
     * @return void
     */
    public function latest_inprogress(Request $request){
        $update_at = Carbon::createFromTimestamp($request['updated_at'])->toDateTimeString();

        if(auth()->user()->hasRole('Manager') || auth()->user()->hasRole('Supervisor')){
            $tasks = Tasks::inProgress()->latestTask('created')->with(['subject', 'latest_task_log.assigned_to_user', 'latest_task_log.assigned_by_user']);
        }
        else{
            $tasks = Tasks::own()->inProgress()->latestTask('created')->with(['subject', 'latest_task_log.assigned_to_user', 'latest_task_log.assigned_by_user']);
        }

        $tasks = $tasks->latest('tasks.updated_at')->latest('tasks.id')
                    ->where('tasks.updated_at','>', $update_at)
                    ->get();

        return response()->json(['success' => true, 'data' => $tasks , 'html' => view('tasks.inprogress_card', compact('tasks'))->render()]);
    }

    public function latest_transfer_request(Request $request){
        $update_at = Carbon::createFromTimestamp($request['updated_at'])->toDateTimeString();
        //Retrieve all transfer request
        if(auth()->user()->hasRole('Manager') || auth()->user()->hasRole('Supervisor')){
            $task_transfer = Tasks::latestTask('transfer')
            ->with(['subject', 'latest_task_log.assigned_to_user', 'latest_task_log.assigned_by_user'])
            ->latest('tasks.updated_at')
            ->where('updated_at', '>', $update_at)
            ->get();
        }else{
            $task_transfer = Tasks::own()->latestTask('transfer')
            ->with(['subject', 'latest_task_log.assigned_to_user', 'latest_task_log.assigned_by_user'])
            ->latest('tasks.updated_at')
            ->where('updated_at', '>', $update_at)
            ->get();
        }
        
        return response()->json(['success' => true , 'data' => $task_transfer ,'html' => view('tasks.transfer_request_card', compact('task_transfer'))->render()]);
    }

    public function latest_team_report(Request $request){
        $completed_at = Carbon::createFromTimestamp($request['completed_at'])->toDateTimeString();

        //Retreiving latest new tasks that are have been completed
        if(auth()->user()->hasRole('Manager') || auth()->user()->hasRole('Supervisor')){
            $tasks_completed = Tasks::complete()
            ->with(['subject', 'latest_task_log.assigned_to_user', 'latest_task_log.assigned_by_user', 'semi_automatic', 'fully_manual', 'product', 'completed_by_user'])
            ->where('tasks.completed_at', '>' ,$completed_at)
            ->latest('completed_at')->get();
        }else{
            $tasks_completed = Tasks::own()->complete()
            ->with(['subject', 'latest_task_log.assigned_to_user', 'latest_task_log.assigned_by_user', 'semi_automatic', 'fully_manual', 'product', 'completed_by_user'])
            ->where('tasks.completed_at', '>' ,$completed_at)
            ->latest('completed_at')->get();
        }
        
        return response()->json(['success' => true ,'data' => $tasks_completed ,'html' => view('tasks.team_report_card', compact('tasks_completed'))->render()]);
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
