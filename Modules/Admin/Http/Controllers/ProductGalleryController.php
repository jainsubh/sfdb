<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\ProductGallery;
use File;
use Response;
use DB;

class ProductGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $gallery = ProductGallery::where('product_id', $request->product_id)->get();
        $gallery_images = [];
        if(!$gallery->isEmpty()){
            foreach($gallery as $img){
                $filename = $img->images;
                $path = storage_path('app/product/photos/' . $filename);

                if (!File::exists($path)) {
                    abort(404);
                }
        
                $filesize = File::size($path);
                $gallery_images[] = array('filename' => $filename, 'size' => $filesize, 'id' => $img->id);
            }
        }
        return Response::json($gallery_images);
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
        if( ProductGallery::findOrFail($id)->delete() ) {
            return response()->json(['status' => 'success'], 200);
        } else {
            return response()->json(['status' => 'error'], 302);
        }
    }
}
