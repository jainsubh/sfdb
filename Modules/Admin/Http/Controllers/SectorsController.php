<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Datatables;
use App\Authorizable;
Use App\Sectors;
Use App\Alert;
Use App\FreeFormReport;
use App\Dataset;


class SectorsController extends Controller
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
        return view('admin::sectors.index', compact('datasets'));
    }

     /**
     * Return datatable format json for user listing
     * @return json
     */

    public function datatable()
    {   
        $sectors = Sectors::latest()->get();
        return Datatables::of($sectors)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {  
        return view('admin::sectors.create')->render();
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {  
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:120|unique:sectors'
        ]);
        if (!$validator->fails()) {
            if(Sectors::create($request->all())){
                flash('Successfully created sector.')->success();
            }else{
                flash('Failed to create sector.')->error();
            }
        }else{
            flash('already exists')->error();
            return redirect()->back()
            ->withErrors($validator)
            ->withInput();
        }
        return redirect()->route('sectors.index');
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
        $sector = Sectors::find($id);
        return view('admin::sectors.edit', compact('sector'))->render();
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
            'name' => 'required|max:120|unique:sectors',
        ]);

        if (!$validator->fails()) {
            
            $sector = Sectors::findOrFail($id);

            $sector->fill($request->only('name'));

            if($sector->save())
            {
                flash('Sector has been updated.')->success();
            }
            else{
                flash('Sector failed to update.')->error();
            }
        } 
        else {
            flash('already exists')->error();
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        return redirect()->route('sectors.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        if( Sectors::findOrFail($id)->delete() ) {
            return 'success';
        } else {
            return 'error';
        }
    }

    public function hasData($id){
        if($sector = Sectors::with(['alerts', 'freeform_reports'])->find($id) ) {
            $sectors = Sectors::all()->pluck("name", "id");
            return response()->json([
                'alerts' => $sector->alerts->count(),
                'freeform_reports' => $sector->freeform_reports->count(),
                'html' => view('admin::sectors.hasData', compact('sector', 'sectors'))->render(),
            ]);
        } else {
            return 'error';
        }
    }

    public function changeSector(Request $request){
        if($request->old_sector_id == $request->sector_id){
            flash('Assign any other sector as this has to be delete')->error();
        }else{
            Alert::where('sector_id', $request->old_sector_id)->update(['sector_id' => $request->sector_id]);
            FreeFormReport::where('sector_id', $request->old_sector_id)->update(['sector_id' => $request->sector_id]);
            $status = $this->destroy($request->old_sector_id);
            if($status == 'success'){
                flash('Sector deleted successfully')->success();
            }else{
                flash('Error in delete this sector')->error();
            }
        }
        return redirect()->back();
    }
}
