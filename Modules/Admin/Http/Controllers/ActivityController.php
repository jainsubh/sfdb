<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Spatie\Activitylog\Models\Activity;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;
use App\User;
use Auth;
use DB;
use App\Dataset;

class ActivityController extends Controller
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
        $activities = Activity::inLog('tasks_log')->latest()->get();
        return response()->json($activities, 200);
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
        //
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
     * latest_activities
     *
     * @param  mixed $request
     * @return void
     */
    public function latest_activities(Request $request)
    {
        $id = $request['latest_id'];
        if(auth()->user()->hasRole('Analyst')){
            $activities = Activity::inLog('tasks_log')->where('id', '>', $id)->where(['properties->assigned_to' => auth()->user()->id])->latest()->get();
        }else{
            $activities = Activity::inLog('tasks_log')->with('subject', 'subject.latest_task_log')->where('id', '>', $id)->latest()->get();
        }
        
        return response()->json(['success' => true , 'data' => $activities, 'html' => view('activity.show', compact('activities'))->render()]);
    }
    
    /**
     * auth_logs
     *
     * @return void
     */
    public function auth_logs(){
        if(Auth::user()->hasRole('Admin')){
            $datasets = $this->datasets;
            return view('admin::auth_logs.index', compact('datasets'));
        }
        else{
            abort(403, "User doesn't have right permissions");
        }
    }
     
    /**
     * auth_logs
     *
     * @return void
     */
    public function report_logs(){
        if(Auth::user()->hasRole('Admin')){
            $datasets = $this->datasets;
            return view('admin::report_logs.index', compact('datasets'));
        }
        else{
            abort(403, "User doesn't have right permissions");
        }
    }

    /**
     * auth_log_datatable
     *
     * @return void
     */
    public function auth_log_datatable(Request $request){
        $auth_logs = Activity::inLog('login', 'logout')->with('causer', 'causer.roles');
        return Datatables::of($auth_logs)
            ->addColumn('user_role', function ($auth_logs) {
                //$user = User::with('roles')->findorFail($auth_logs->causer_id);
                if($auth_logs->causer->roles->first()->name == 'Admin'){
                    $class = 'badge badge-success m-2';
                }
                elseif($auth_logs->causer->roles->first()->name == 'Manager'){
                    $class = 'badge badge-info m-2';
                }
                elseif($auth_logs->causer->roles->first()->name == 'Supervisor'){
                    $class = 'badge badge-secondary m-2';
                }
                else{
                    $class = 'badge badge-warning m-2';
                }
                return '<span class="badge '.$class.' m-2">'.$auth_logs->causer->roles->first()->name.'</span>';
            })->rawColumns(['user_role'])
            ->editColumn('log_name', function ($auth_logs){ 
                return ucfirst($auth_logs->log_name); 
            })
            ->editColumn('created_at', function ($auth_logs) {
                return Carbon::parse($auth_logs->created_at, 'UTC')->setTimezone(auth()->user()->timezone);
            })->make(true);
    }

    /**
     * auth_log_datatable
     *
     * @return void
     */
    public function report_log_datatable(Request $request){
        $report_logs = Activity::inLog('alert_log', 'external_reports_log', 'freeform_reports_log', 'fully_manual_log', 'institution_reports_log', 'product_log')->with('causer', 'causer.roles')->orderBy('created_at','desc');
        
        return Datatables::of($report_logs)
            ->addColumn('user_role', function ($report_logs) {
                if($report_logs->causer->roles->first()->name == 'Admin'){
                    $class = 'badge badge-success m-2';
                }
                elseif($report_logs->causer->roles->first()->name == 'Manager'){
                    $class = 'badge badge-info m-2';
                }
                elseif($report_logs->causer->roles->first()->name == 'Supervisor'){
                    $class = 'badge badge-secondary m-2';
                }
                else{
                    $class = 'badge badge-warning m-2';
                }
                return '<span class="badge '.$class.' m-2">'.$report_logs->causer->roles->first()->name.'</span>';
            })->rawColumns(['user_role'])
            ->addColumn('ref_id', function ($report_logs) {
                return $report_logs->subject->ref_id;
            })
            ->editColumn('log_name', function ($report_logs){ 
                return ucfirst($report_logs->log_name); 
            })
            ->editColumn('created_at', function ($report_logs) {
                return Carbon::parse($report_logs->created_at, 'UTC')->setTimezone(auth()->user()->timezone);
            })->make(true);
    }
}
