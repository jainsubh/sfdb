<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Validator;
use App\Event;
use App\Authorizable;
Use App\Departments;
Use App\User;
Use App\Sectors;
Use App\CrawlLog;
use App\Dataset;
use Config;
use DB;


class EventsController extends Controller
{
    use Authorizable;

    public $scma_url;
    public $datasets;
    
    public function __construct(){
        $this->scma_url = Config::get('scma.url');
        $this->datasets = Dataset::latest()->get();
    }
    
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {   
        $datasets = $this->datasets;
        $departments = Departments::all();
        return view('admin::events.index', compact('datasets'))->with('departments', $departments);
    }

    /**
     * Return datatable format json for user listing
     * @return json
     */

    public function datatable()
    {   
        if(auth()->user()->hasRole('Analyst'))
            $events = Event::own()->with('created_by_user','modified_by_user', 'crawl_log')->latest()->active()->get();
        else
            $events = Event::with('created_by_user','modified_by_user', 'crawl_log')->latest()->active()->get();


        return Datatables::of($events) 
        ->addColumn('sectors', function ($events) {
            return $events->sectors()->pluck('name')->toArray();
        })->rawColumns(['sectors'])
        ->editColumn('crawl_type', function ($events){ 
            if($events->crawl_type == 0)
                return "Entire Website";
            else 
                return "Only New Articles";
        })->rawColumns(['crawl_type'])->make(true);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $datasets = $this->datasets;
        $departments = Departments::all()->pluck("name", "id");
        $users = User::role('Analyst')->pluck('name', 'id');
        $sectors = Sectors::all()->pluck("name", "id");
        return view('admin::events.create')->with(compact('departments','users','sectors', 'datasets'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        if(auth()->user()->hasRole('Analyst')){
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:events,name',
                'department_id' => 'required',
                'created_by' => 'required',
                'match_condition' => 'required',
                'sector_id' => 'required',
                'crawl_type' => 'required',
                'start_date' => 'required'
            ],[
                'name.unique' => 'Event name already exists, kindly enter another event name.'
            ]);
        }
        else{
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:events,name',
                'department_id' => 'required',
                'user_id' => 'required',
                'created_by' => 'required',
                'match_condition' => 'required',
                'sector_id' => 'required',
                'crawl_type' => 'required',
                'start_date' => 'required'
            ],[
                'name.unique' => 'Event name already exists, kindly enter another event name.'
            ]);
        }

        if (!$validator->fails()) {
            if($event = Event::create($request->except(['department_id']))){
                if($request->department_id != '' && is_array($request->department_id)){
                    $department_id = $request->department_id;
                    $event->departments()->attach($department_id);
                }else{
                    $department_id = explode(",", $request->department_id);
                    $event->departments()->attach($department_id);
                }

                if($request->user_id != ''  && is_array($request->user_id)){
                    $user_id = $request->user_id;
                    $event->users()->attach($user_id);
                }else{
                    $user_id = explode(",", $request->user_id);
                    $event->users()->attach($user_id);
                }

                /*
                if($request->department_id != ''){
                    $department_id = explode(",", $request->department_id);
                    $event->departments()->attach($department_id);
                }

                if($request->user_id != ''){
                    $user_id = explode(",", $request->user_id);
                    $event->users()->attach($user_id);
                }
                */

                $send_data = [
                    'id' => $event->id,
                    'name' => $request->name,
                    'match_condition' => $request->match_condition,
                    'crawl_type' => $request->crawl_type,
                    'id' => $event->id
                ];

                if(count($department_id) > 0){
                    $external_dept = Departments::whereIn('id', $department_id)->pluck("external_id")->toArray();
                    $send_data['categories'] = array_map(function($value) {
                        return ['category_id' => $value];
                    }, $external_dept);
                }

                $client = new \GuzzleHttp\Client();
                $response = $client->post(
                    $this->scma_url.'events',
                    [
                        'headers' => [
                            'Content-Type' => 'application/json',
                        ],
                        'json' => $send_data,
                    ]
                );
                $body = $response->getBody();
                $response_json = json_decode((string) $body);

                if($response->getStatusCode() == 200){
                    $event->external_id = $response_json->data->id;
                    $event->save();
                    flash('Successfully created event.')->success();
                }else{
                    flash('ERROR - '.(string) $body)->error();
                }
            }
            else{
                flash('Failed to create event.')->error();
            }
        }else{
            return redirect()->back()
            ->withErrors($validator)
            ->withInput();
        }
        return redirect()->route('events.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $event = Event::with(['alerts', 'departments:id,name','users:id,name','sectors:id,name','created_by_user'])->where('id', $id)->active()->first();
        
        if(auth()->user()->hasRole('Analyst') && $this->checkAnalystExist($id)){
            return response()->json('Analyst has been removed from this alert', 500);
        }
        if($event == null){
            return response()->json('Could not Open , this event has been deleted', 500);
        }
        return view('admin::events.show')->with(compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $datasets = $this->datasets;
        $departments = Departments::all()->pluck("name", "id");
        $users = User::role('Analyst')->pluck('name', 'id');
        $sectors = Sectors::all()->pluck("name", "id");
        $event = Event::with(['departments:id,name','users:id,name','sectors:id,name','created_by_user'])->where('id', $id)->first();
        
        $select_departments = array();
        if(isset($event->departments) && $event->departments->count() > 0){
            foreach($event->departments as $key => $value){
                $select_departments[] = strval($value->id);
            }
        }
        $select_departments = json_encode($select_departments);

       
        $selected_users = array();
        if(isset($event->users) && $event->users->count() > 0){
            foreach($event->users as $key => $value){
                $selected_users[] = strval($value->id);
            }
        }
        else if(isset($event->created_by_user)){
            $selected_users[] = strval($event->created_by_user->id);
        }
        $selected_users = json_encode($selected_users);
        
        return view('admin::events.edit', compact('event','departments','users','selected_users','sectors','select_departments', 'datasets'))->render();
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        if(auth()->user()->hasRole('Analyst')){
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:events,name,'.$id,
                'department_id' => 'required',
                'modified_by' => 'required',
                'match_condition' => 'required',
                'sector_id' => 'required',
                'crawl_type' => 'required',
                'start_date' => 'required'
            ],[
                'name.unique' => 'Event name already exists, kindly enter another event name.'
            ]);
        }
        else{
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:events,name,'.$id,
                'department_id' => 'required',
                'user_id' => 'required',
                'modified_by' => 'required',
                'match_condition' => 'required',
                'sector_id' => 'required',
                'crawl_type' => 'required',
                'start_date' => 'required'
            ],[
                'name.unique' => 'Event name already exists, kindly enter another event name.'
            ]);
        }
        
        
        if (!$validator->fails()) {
            $event = Event::findOrFail($id);

            $send_data = [
                'name' => $request->name,
                'match_condition' => $request->match_condition,
                'crawl_type' => $request->crawl_type,
            ];
            $event->fill(
                        array(
                            'name' => $request->name, 
                            'match_condition' => $request->match_condition,
                            'sector_id' => $request->sector_id,
                            'crawl_type' => $request->crawl_type,
                            'modified_by' => $request->modified_by,
                            'status' => $request->status,
                            'start_date' => $request->start_date,
                            'end_date' => $request->end_date
                        )
                    );
            if($event->save())
            {
                if($request->department_id != ''){
                    $department_id = explode(",", $request->department_id);
                    $event->departments()->sync($department_id);
                }

                if($request->user_id != ''){
                    $user_id = explode(",", $request->user_id);
                    $event->users()->sync($user_id);
                }

                if(count($department_id) > 0){
                    $external_dept = Departments::whereIn('id', $department_id)->pluck("external_id")->toArray();
                    $send_data['categories'] = array_map(function($value) {
                        return ['category_id' => $value];
                    }, $external_dept);
                }

                $client = new \GuzzleHttp\Client();
                $response = $client->put(
                    $this->scma_url.'events/'.$event->external_id,
                    [
                        'headers' => [
                            'Content-Type' => 'application/json',
                        ],
                        'json' => $send_data,
                    ]
                );

                $body = $response->getBody();
                if($response->getStatusCode() == 200){
                    flash('Event has been updated.')->success();
                }else{
                    flash('ERROR - '.(string) $body)->error();
                }
            }
            else{
                flash('Event failed to update.')->error();
            }
        } 
        else {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        return redirect()->route('events.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {   
        $event = Event::findOrFail($id);
        if( $event->delete() ) {
            $client = new \GuzzleHttp\Client();
            $response = $client->delete($this->scma_url.'events/'.$event->external_id);

            if($response->getStatusCode() == 200){
                return 'success';
            }
        } else {
            return 'error';
        }
    }

    public function detail_event_info(Request $request){
        $event_exists = Event::where('id', $request->event_id)->active()->first();
        if($event_exists == null){
            return response()->json('Event has been deleted', 500);
        }
        if($request->detail_type == 'departments'){
            $event = Event::with(['departments:name'])->where('id', $request->event_id)->first();
            $departments = $event->departments->toArray();
            return response()->json(['success' => true , 'data' => $departments]);
        } 
        else if($request->detail_type == 'keywords'){
            $event = Event::where('id', $request->event_id)->first();
            $keywords = str_replace([ '(', ')', ' or', ' and',' OR',' AND'],'',$event->match_condition);
            $keywords = explode(' ^',  $keywords);
            foreach($keywords as $id => $keyword){
                $keywords[$id] = str_replace('^','',$keyword);
            }
            return response()->json(['success' => true , 'data' => $keywords]);
        }
        else if($request->detail_type == 'sites'){
            $event = Event::with(['departments.sites:company_url'])->where('id', $request->event_id)->first();
            $sites = [];
            foreach($event->departments as $id => $department){
                $sites = array_merge($sites, $department->sites->pluck('company_url')->toArray());
            }
            $sites = array_unique($sites);
            return response()->json(['success' => true , 'data' => $sites]);
        }
        else 
            return response()->json(['error' => 'Some error appeared', 402]);
    }

    public function latest_events(Request $request){
        $events = [];
        if(auth()->user()->hasRole('Analyst'))
            $events = Event::own()->with(['sectors','created_by_user','eventuser'])->active()->where('id','>', $request['id'])->latest('id')->get();
        else
            $events = Event::with(['sectors','created_by_user','eventuser'])->active()->where('id','>', $request['id'])->latest('id')->get();
            
        $latest_event_id = $events->pluck('id')->first();
        return response()->json(['success' => true ,'html' => view('admin::events.event_card', compact('events'))->render(), 'latest_event_id'=>$latest_event_id]);
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

    public function immediate_crawl(Request $request, $id){
        //DB::enableQueryLog(); // Enable query log
        //dd('ss');
        $event = Event::with(['departments.sites:company_url', 'created_by_user','modified_by_user'])->where('id', $id)->where('event_lock', '0')->first();
        if(!$event){
            return response()->json('Event not found',302);
        }

        $sites = [];
        foreach($event->departments as $id => $department){
            $sites = array_merge($sites, $department->sites->pluck('company_url')->toArray());
        }
        $sites = array_unique($sites);

        
        DB::beginTransaction();
        if($event && $event->status == 'active'){
            if($event->update(['event_lock' => 1])){

                $sendData = array('event_id' => $event->external_id);
             
                $client = new \GuzzleHttp\Client();
                $response = $client->post(
                    $this->scma_url.'crawl_job',
                    [
                        'headers' => [
                            'Content-Type' => 'application/json',
                        ],
                        'json' => $sendData,
                    ]
                );
                $body = $response->getBody();
                $response_json = json_decode((string) $body);

                if($response->getStatusCode() == 200){
                    $external_id = $response_json->data->id;
                    
                    $event_log = [
                        'event_id' => $event->id,
                        'status' => 'in_queue',
                        'no_of_sites' => count($sites),
                        'external' => $external_id
                    ];

                    if(CrawlLog::Create($event_log)){

                        $event_with_log = Event::with('created_by_user','modified_by_user', 'crawl_log')->where('id', $event->id)->latest()->first();

                        $name = $event_with_log->sectors()->pluck('name');
                        
                        $event_with_log->sectors = $name;

                        if($event->crawl_type == 0){
                            $event_with_log->crawl_type = "Entire Website";
                        }else {
                            $event_with_log->crawl_type = "Only New Articles";
                        }
                        
                        DB::commit();

                        return response()->json([
                            'status'=>'Success',
                            'message' => 'Event crawl started',
                            'data' => $event_with_log
                        ], 200);
                    }
                    else{
                        DB::rollBack();
                        return response()->json('Error - something went wrong on immediate crawl',302);
                    }
                }else{
                    DB::rollBack();
                    return response()->json('Error - something went wrong on immediate crawl',302);
                }

            }else{
                DB::rollBack();
                return response()->json('Event Crawl already in process, wait for sometime',302);
            }
        }else{
            DB::rollBack();
            return response()->json('Deactivated event can not be crawl',302);
        }
        
    
    }

    public function crawl_status($id){
        $crawl_result = CrawlLog::where('event_id', $id)->latest()->first();
        return response()->json([
            'status'=>'Success',
            'message' => 'Event crawl started',
            'data' => $crawl_result
        ], 200);
    }

    public function crawl_multiple_status(){
        //dd('s');
        $crawlLogs = CrawlLog::where('status', '!=', 'complete')->get();
        $jobs = $crawlLogs->pluck('external')->toArray();
        //dd($jobs);
        if(count($jobs) > 0){
            $sendData = array('jobs' => $jobs);
            //dd($sendData);
            $client = new \GuzzleHttp\Client();
            $response = $client->post(
                $this->scma_url.'crawl_multiple_status',
                [
                    'headers' => [
                        'Content-Type' => 'application/json',
                    ],
                    'json' => $sendData,
                ]
            );
            $body = $response->getBody();
            $response_json = json_decode((string) $body);

            if(count($response_json->data) > 0){
                foreach($response_json->data as $job_status){
                    $save_data = array(
                        'status' => $job_status->status,
                        'site_completed' => $job_status->site_completed,
                        'completed_at' => $job_status->completed_at
                    );

                    if(CrawlLog::where('external', $job_status->id)->update($save_data)){
                        if($job_status->status == 'complete'){
                            $crawlLog = CrawlLog::where('external', $job_status->id)->first();
                            Event::where('id', $crawlLog->event_id)->update(['event_lock' => 0]);
                        }
                    }   
                }
            }

            return response()->json('Event status saved successfully',200);
        }
    }
}
