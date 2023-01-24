<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Product;
use App\Tasks;
use App\Sectors;
use App\ProductGallery;
use PDF;
use IMAGE;

class ProductController extends Controller
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
        //dd($request['task_id']);
        $validator = Validator::make($request->all(), [
            'task_id' => 'required',
        ]);
        
        if ($validator->fails()){
            return response()->json($validator->errors()->first(), 302);
        }

        $product_report = Product::inProgress()->where('task_id', $request->task_id)->first();
        if($product_report){
            return response()->json([
                'status' => 'success',
                'message' => 'Report already in Progress',
                'data' => $product_report
            ], 200);
        }

        $task = Tasks::findorFail($request->task_id);

        //Generate INSR number for Institutional Report
        $randomid = mt_rand(100000,999999); 
        $current_date_time = Carbon::now('UTC')->timestamp;
        $reportfilename = 'PR-'.$randomid.'-'.$current_date_time;

        $request['type'] = $task->subject_type;
        $request['ref_id'] = $reportfilename;
        $request['report_by'] = auth()->user()->id;
        $request['status'] = 'progress';

        $manual_data = Product::create($request->all());

        if($manual_data){
            return response()->json([
                'status' => 'success',
                'message' => 'Report data save successfully',
                'data' => $manual_data
            ], 200);
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create manual report'
            ], 500);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $product_report = Product::with('sectors','gallery')->findOrFail($id);
        return view('report_template.product', compact(['product_report']));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $product_report = Product::inProgress()->findOrFail($id);
        $sectors = Sectors::all()->pluck("name", "id");
        return view('admin::product.edit', compact(['product_report', 'sectors']));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $product_report = Product::inProgress()->findOrFail($id);

        if($request->hasFile('file')){
            $validator = Validator::make($request->all(), [
                'file' => 'required|image|mimes:jpeg,png,jpg',
            ]);
            
            if ($validator->fails()){
                return response()->json($validator->errors()->first(), 302);
            }

            $image      = $request->file;
            $fileName   = time().'_'.$image->getClientOriginalName();
            if($image->storeAs('product/photos', $fileName)){
                $product_report->gallery()->save(new ProductGallery(['images' => $fileName]));     
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Images added successfully',
                'data' => $product_report->gallery->last()
            ], 200);
        }
        else{
            $update = $product_report->task()->update(['updated_at' => now()]);
            if($product_report->update($request->all())){
                return response()->json([
                    'status' => 'success',
                    'message' => 'Report data save successfully',
                    'data' => $product_report
                ], 200);
            }
        }

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

    public function complete(Request $request, $id)
    {
        $product_report = Product::with('sectors','gallery')->findOrFail($id);
        
        $pdf = PDF::loadHTML(view('report_template.product', compact(['product_report'])));
        $pdf->save(storage_path('app/product/'.$product_report->ref_id.'.pdf'), $overwrite = true);

        $product_report->status = 'complete';
        
        if($product_report->save()){
            flash('Report completed successfully')->success();
            return redirect()->route('tasks.index');    
        }else {
            return redirect()->back()
                        ->withErrors(['Failed to complete report'])
                        ->withInput();
        }
    }

    public function download($filename, $filetype = 'pdf')
    {
        $filepath = 'product/'.$filename.'.'.$filetype;
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

    public function regenerate($id){
        $product_report = Product::where('id', $id)->firstOrFail();
        if($product_report->status == 'progress'){
            return response()->json([
                'status'=>'Error',
                'message' => "Report can't be continued, already in pending status"
            ], 409);
        }else{
            $product_report->status = 'progress';
            if($product_report->save()){
                return response()->json([
                    'status'=>'Success',
                    'message' => 'Report reopened successfully',
                    'id' => $product_report->id
                ], 200);
            }else{
                return response()->json('Error - while continuing report',302);
            }
        }
    }
}
