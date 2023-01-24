<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Datatables;
use App\Authorizable;
Use App\OrganizationUrl;
use App\Dataset;

class OrganizationUrlController extends Controller
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
        return view('admin::organization_url.index', compact('datasets'));
    }

     /**
     * Return datatable format json for user listing
     * @return json
     */

    public function datatable()
    {   
        $organisation_url = OrganizationUrl::orderBy('id','desc')->get();
        return Datatables::of($organisation_url)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('admin::organization_url.create')->render();
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'name' => 'required|max:120',
            'url' => 'required|unique:organization_urls'
        ]);
        if (!$validator->fails()) {
            if(OrganizationUrl::create($request->all())){
                flash('Successfully created Organisation Url.')->success();
            }else{
                flash('Failed to create Organisation Url.')->error();
            }
        }else{
            flash('already exists')->error();
            return redirect()->back()
            ->withErrors($validator)
            ->withInput();
        }
        return redirect()->route('organization_url.index');
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
        $organization_url = OrganizationUrl::find($id);
        return view('admin::organization_url.edit', compact('organization_url'))->render();
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
            'name' => 'required|max:120',
            'url' => 'required'
        ]);

        if (!$validator->fails()) {
            
            $organisation_url = OrganizationUrl::findOrFail($id);

            $organisation_url->fill(array('name' => $request->name, 'url' => $request->url));

            if($organisation_url->save())
            {
                flash('Organization URL has been updated.')->success();
            }
            else{
                flash('Organization URL failed to update.')->error();
            }
        } 
        else {
            flash('already exists')->error();
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        return redirect()->route('organization_url.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        if( OrganizationUrl::findOrFail($id)->delete() ) {
            return 'success';
        } else {
            return 'error';
        }
    }
}
