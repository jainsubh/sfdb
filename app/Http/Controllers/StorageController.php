<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;
use Response;

class StorageController extends Controller
{
    public function uploadImage(Request $request, $folder = 'fully_manual') {
        if($request->hasFile('file')){
            $validator = Validator::make($request->all(), [
                'file' => 'required|image|mimes:jpeg,png,jpg',
            ]);
            
            if ($validator->fails()){
                return response()->json($validator->errors()->first(), 302);
            }
            $image      = $request->file;
            $fileName   = time().'_'.$image->getClientOriginalName();
            if($image->storeAs($folder.'/photos', $fileName)){
                return response()->json(['file_name' => $fileName]);
            }else{
                return response()->json(['error' => 'Not able to save file'], 401);
            }
        }
    }

    public function displayImage($filename, $folder = 'fully_manual', $subfolder = 'photos')
    {
        $path = storage_path('app/'.$folder.'/'.$subfolder.'/' . $filename);
        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    }

    
}
