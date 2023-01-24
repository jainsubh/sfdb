<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use App\ReportTemplate;
use Yajra\Datatables\Datatables;
use File;
use App\Authorizable;
use App\Dataset;

class ReportTemplateController extends Controller
{
    use Authorizable;

    public $datasets;

    public function __construct(){
        $this->datasets = Dataset::latest()->get();
    }

    /**
     * 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datasets = $this->datasets;
        $report_template = ReportTemplate::latest()->get();
        return view('admin::report_template.index', compact('report_template', 'datasets'));
    }

    public function datatable()
    {
        $report_template = ReportTemplate::latest()->get();
        return Datatables::of($report_template)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $report_template = ReportTemplate::find($id);
        $task = '';
        if($report_template->type == 'freeform_report'){
            $freeform_report = '';
            return view('report_template.'.$report_template->type, compact(['freeform_report']));
        }
        return view('report_template.'.$report_template->type, compact(['task']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $datasets = $this->datasets;
        $report_template = ReportTemplate::find($id);
        if(Storage::disk('local')->exists('report_template/'.$report_template->type.'.html')){
            $html_template = Storage::disk('local')->get('report_template/'.$report_template->type.'.html');
        }else{
            $html_template = '';
        }
        
        return view('admin::report_template.edit', compact('report_template', 'html_template', 'datasets'))->render();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(!File::isDirectory(resource_path('views/report_template/'))){
            File::makeDirectory(resource_path('views/report_template/'), 0777, true);
        }
        File::put(resource_path('views/report_template/' . $request->type . '.blade.php'), $request->code); 
        Storage::disk('local')->put('report_template/'.$request->type.'.html', $request->code);
        
        return response()->json([
            'id' => $id,
            'status' => 'success',
            'message' => 'Report Template save successfully',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
