<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Validator;
use App\Dataset;
use App\Data;

class DataController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('admin::index');
    }

    /**
     * Return datatable format json for user listing
     * @return json
     */
    public function datatable($dataset_id)
    {   
        $data = Data::where('dataset_id', $dataset_id)->get();
        return Datatables::of($data)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Request $request)
    {
        $dataset_id = $request->dataset_id;
        return view('admin::data.create', compact('dataset_id'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:120|unique:data'
        ]);
        if (!$validator->fails()) {
            if(Data::create($request->all())){
                flash('Successfully added.')->success();
            }else{
                flash('Failed to add.')->error();
            }
        }else{
            flash('already exists')->error();
            return redirect()->back()
            ->withErrors($validator)
            ->withInput();
        }
        return redirect()->route('dataset.show', $request->dataset_id);
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
        $data = Data::find($id);
        return view('admin::data.edit', compact('data'))->render();
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
            'name' => 'required|max:120|unique:data',
        ]);

        if (!$validator->fails()) {
            
            $data = Data::findOrFail($id);

            $data->fill($request->only('name'));

            if($data->save())
            {
                flash('Updated successfully.')->success();
            }
            else{
                flash('Failed to update.')->error();
            }
        } 
        else {
            flash('already exists')->error();
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        return redirect()->route('dataset.show', $data->dataset_id);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        if( Data::findOrFail($id)->delete() ) {
            return 'success';
        } else {
            return 'error';
        }
    }
}
