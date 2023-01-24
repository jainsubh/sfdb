<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Datatables;
use App\Authorizable;
Use App\Departments;
use App\EventDepartment;
use App\SiteDepartment;
use Config;
use App\Dataset;

class DepartmentsController extends Controller
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
    public function index(){
        $datasets = $this->datasets;
        return view('admin::departments.index', compact('datasets'));
    }

     /**
     * Return datatable format json for user listing
     * @return json
     */

    public function datatable(){   
        $departments = Departments::latest()->get();
        return Datatables::of($departments)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(){
        return view('admin::departments.create')->render();
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:120|unique:departments',
        ]);

        if (!$validator->fails()) {
            
            if($department = Departments::create($request->only('name')) ) {

                $client = new \GuzzleHttp\Client();
                $response = $client->post(
                    $this->scma_url.'categories',
                    [
                        'headers' => [
                            'Content-Type' => 'application/json',
                        ],
                        'json' => $request->only('name'),
                    ]
                );
                $response_body = $response->getBody();
                $response_arr = json_decode((string) $response_body);

                if($response->getStatusCode() == 200){
                    $department->external_id = $response_arr->data->id;
                    $department->save();
                    flash('Department Added')->success();
                }else{
                    flash('ERROR - '.json_encode($response_body))->error();
                }
                
            }
            else {
                flash('Failed to create Department.')->error();
            }
        }
        else {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        return redirect()->back();
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id){
        return view('admin::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id){
        $department = Departments::find($id);
        return view('admin::departments.edit', compact('department'))->render();
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:120|unique:departments',
        ]);

        if (!$validator->fails()) {
            
            $department = Departments::findOrFail($id);

            $department->fill($request->only('name'));

            if($department->save())
            {
                $client = new \GuzzleHttp\Client();
                $response = $client->put(
                    $this->scma_url.'categories/'.$department->external_id,
                    [
                        'headers' => [
                            'Content-Type' => 'application/json',
                        ],
                        'json' => $request->only('name'),
                    ]
                );

                $response_body = $response->getBody();

                if($response->getStatusCode() == 200){
                    flash('Department has been updated.')->success();
                }else{
                    flash('ERROR - '.json_encode((string) $response_body))->error();
                }
            }
            else{
                flash('Department failed to update.')->error();
            }
        } 
        else {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        return redirect()->route('departments.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id){
        $department = Departments::findOrFail($id);
        if( $department->delete() ) {

            $client = new \GuzzleHttp\Client();
            $response = $client->delete($this->scma_url.'categories/'.$department->external_id);
            if($response->getStatusCode() == 200){
                return 'success';
            }
        } else {
            return 'error';
        }
    }

    public function hasData($id){
        if($department = Departments::with(['sites', 'events'])->find($id) ) {
            $departments = Departments::all()->pluck("name", "id");
            return response()->json([
                'sites' => $department->sites->count(),
                'events' => $department->events->count(),
                'html' => view('admin::departments.hasData', compact('department', 'departments'))->render(),
            ]);
        } else {
            return 'error';
        }
    }

    public function changeDepartment(Request $request){
        if($request->old_department_id == $request->department_id){
            flash('Assign any other department as this has to be delete')->error();
        }else{
            //try{
                $eventDepartments = EventDepartment::where('departments_id', $request->old_department_id)->get();
                
                if($eventDepartments)
                foreach($eventDepartments as $eventDepartment){
                    if(!EventDepartment::where([
                        ['departments_id', $request->department_id],
                        ['event_id', $eventDepartment->event_id],
                    ])->exists()){
                        echo 'Record update for Department ID -> '.$request->department_id.' and event id ->'.$eventDepartment->event_id.'<br />';
                        EventDepartment::where([
                            ['departments_id', $request->old_department_id],
                            ['event_id', $eventDepartment->event_id]
                        ])->update(['departments_id' => $request->department_id]);
                    }else{
                        echo 'Data exists for Department ID -> '.$request->department_id.' and event id ->'.$eventDepartment->event_id.'<br />';
                        EventDepartment::where([
                            ['departments_id', $request->old_department_id],
                            ['event_id', $eventDepartment->event_id]
                        ])->delete();
                    }
                }

                //SiteDepartment::where('departments_id', $request->old_department_id)->update(['departments_id' => $request->department_id]);
                $siteDepartments = SiteDepartment::where('departments_id', $request->old_department_id)->get();
                
                if($siteDepartments)
                foreach($siteDepartments as $siteDepartment){
                    if(!SiteDepartment::where([
                        ['departments_id', $request->department_id],
                        ['site_id', $siteDepartment->site_id],
                    ])->exists()){
                        echo 'Record update for Department ID -> '.$request->department_id.' and event id ->'.$siteDepartment->site_id.'<br />';
                        SiteDepartment::where([
                            ['departments_id', $request->old_department_id],
                            ['site_id', $siteDepartment->site_id]
                        ])->update(['departments_id' => $request->department_id]);
                    }else{
                        echo 'Data exists for Department ID -> '.$request->department_id.' and event id ->'.$siteDepartment->site_id.'<br />';
                        SiteDepartment::where([
                            ['departments_id', $request->old_department_id],
                            ['site_id', $siteDepartment->site_id]
                        ])->delete();
                    }
                }
                
                $department = Departments::findOrFail($request->department_id);
                $old_department = Departments::findOrFail($request->old_department_id);

                
                $client = new \GuzzleHttp\Client();
                $response = $client->put(
                    $this->scma_url.'categories/changeCategory',
                    [
                        'headers' => [
                            'Content-Type' => 'application/json',
                        ],
                        'json' => ['old_department_id' => $old_department->external_id, 'department_id' => $department->external_id],
                    ]
                );

                $response_body = $response->getBody();
                
                if($response->getStatusCode() == 200){
                    $status = $this->destroy($request->old_department_id);
                    flash('Department deleted successfully')->success();
                }else{
                    flash('Error in delete this department')->error();
                }
            /*}
            catch(QueryException $e){
                if($e->errorInfo[1] == 1062){
                    flash('Selected department already assign to event or site, Kindly select another department')->error();
                }else{
                    flash($e->errorInfo[2])->error();
                }
            }*/
        }
        return redirect()->back();
    }
}
