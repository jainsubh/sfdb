<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Validator;
use App\Authorizable;
Use DB;
Use App\Site;
Use App\Departments;
use App\Dataset;
use Config;

class SitesController extends Controller
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
        $datasets = $this->datasets;
        $departments = Departments::all();
        return view('admin::sites.index', compact('datasets'))->with('departments', $departments);
    }

    /**
     * Return datatable format json for user listing
     * @return json
     */

    public function datatable()
    {   
        $sites = Site::latest()->get();
        return Datatables::of($sites)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {  
        $datasets = $this->datasets;
        $departments = Departments::all()->pluck("name", "id");
        return view('admin::sites.create')->with(compact('departments', 'datasets'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_name' => 'required|unique:sites',
            'company_url' => 'required',
            'crawl' => 'required',
            'crawl_interval' => 'required',
            'crawl_depth' => 'required',
            'site_type' => 'required',
            'department_id' => 'required',
        ]);

        if (!$validator->fails()){
            if($site = Site::create($request->except(['department_id']))){
                $department_id = [];
                if($request->department_id != ''){
                    $department_id = explode(",", $request->department_id);
                    $site->departments()->attach($department_id);
                }

                $send_data = [
                    'url' => $request->company_url,
                    'name' => $request->company_name,
                    'crawl' => $request->crawl,
                    'site_color' => $request->site_color,
                    'site_type' => $request->site_type,
                    'interval' => $request->crawl_interval,
                    'depth' => $request->crawl_depth,
                ];
        
                if($request->selector){
                    $send_data['site_selector'] = $request->selector;
                }
                if($request->selector_value){
                    $send_data['selector_value'] = $request->selector_value;
                }
        
                if(count($department_id) > 0){
                    $external_dept = Departments::whereIn('id', $department_id)->pluck("external_id")->toArray();
                    $send_data['categories'] = array_map(function($value) {
                        return ['category_id' => $value];
                    }, $external_dept);
                }
                
                $client = new \GuzzleHttp\Client();
                $response = $client->post(
                    Config::get('scma.url').'sites',
                    [
                        'headers' => [
                            'Content-Type' => 'application/json',
                        ],
                        'json' => $send_data
                    ]
                );
                $body = $response->getBody();
                $response_json = json_decode((string) $body);

                if($response->getStatusCode() == 200){
                    $site->external_id = $response_json->data->id;
                    $site->save();
                    flash('Successfully created Site.')->success();
                }else{
                    flash('ERROR - '.(string) $body)->error();
                }
            }
            else{
                flash('Failed to create Site.')->error();
            }
        }else{
            flash('Validation Failed')->error();
            return redirect()->back()
            ->withErrors($validator)
            ->withInput();
        }
        return redirect()->route('sites.index');
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
        $datasets = $this->datasets;
        $departments = Departments::all()->pluck("name", "id");
        $site = Site::with('departments:id,name')->where('id', $id)->first();
        $selected_department_arr = $site->departments->pluck('id')->toArray();
        
        $select_departments = null;
        if(count($selected_department_arr) > 0){
            $select_departments = json_encode(array_map('strval', $selected_department_arr));
        }
        
        return view('admin::sites.edit', compact('site','departments','select_departments', 'datasets'))->render();
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {   
        $validator = Validator::make($request->all(), [
            'company_name' => 'required',
            'company_url' => 'required',
            'crawl' => 'required',
            'crawl_interval' => 'required',
            'crawl_depth' => 'required',
            'site_type' => 'required',
            'department_id' => 'required',
        ]);
        
        if (!$validator->fails()) {
            
            $site = Site::findOrFail($id);
            $site->fill(
                        array(
                            'company_name' => $request->company_name, 
                            'company_url' => $request->company_url,
                            'crawl' => $request->crawl,
                            'crawl_interval' => $request->crawl_interval,
                            'crawl_depth' => $request->crawl_depth,
                            'site_color' => $request->site_color,
                            'site_type' => $request->site_type,
                            'selector' => $request->selector,
                            'selector_value' => $request->selector_value
                        )
                    );
            if($site->save())
            {
                if($request->department_id != ''){
                    $department_id = explode(",", $request->department_id);
                    $site->departments()->sync($department_id);
                }

                $send_data = [
                    'url' => $request->company_url,
                    'name' => $request->company_name,
                    'crawl' => $request->crawl,
                    'site_color' => $request->site_color,
                    'site_type' => $request->site_type,
                    'interval' => $request->crawl_interval,
                    'depth' => $request->crawl_depth,
                    'site_selector' => $request->selector,
                    'selector_value' => $request->selector_value,
                ];
        
                if(count($department_id) > 0){
                    $external_dept = Departments::whereIn('id', $department_id)->pluck("external_id")->toArray();
                    
                    $send_data['categories'] = array_map(function($value) {
                        return ['category_id' => $value];
                    }, $external_dept);
                }
                    
                $client = new \GuzzleHttp\Client();
                $response = $client->put(
                    Config::get('scma.url').'sites/'.$site->external_id,
                    [
                        'headers' => [
                            'Content-Type' => 'application/json',
                        ],
                        'json' => $send_data
                    ]
                );

                $body = $response->getBody();

                if($response->getStatusCode() == 200){
                    flash('Site has been updated.')->success();
                }else{
                    flash('ERROR - '.(string) $body)->error();
                }
            }
            else{
                flash('Site failed to update.')->error();
            }
        } 
        else {
            flash('Validation Failed')->error();
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        return redirect()->route('sites.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $site = Site::findOrFail($id);
        if( $site->delete() ) {

            $client = new \GuzzleHttp\Client();
            $response = $client->delete(Config::get('scma.url').'sites/'.$site->external_id);

            if($response->getStatusCode() == 200){
                return 'success';
            }
        } else {
            return 'error';
        }
    }
}
