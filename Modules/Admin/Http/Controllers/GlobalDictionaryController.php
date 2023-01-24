<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\Datatables\Datatables;
use App\GlobalDictionary;
use App\Authorizable;
use Illuminate\Support\Facades\Validator;
use Config;
use App\Dataset;

class GlobalDictionaryController extends Controller
{
    use Authorizable;
    public $scma_url;

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
        $dictionary = GlobalDictionary::latest()->get();
        return view('admin::global_dictionary.index', compact('dictionary', 'datasets'));
    }

    public function datatable()
    {
        $dictionary = GlobalDictionary::latest()->get();
        return Datatables::of($dictionary)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('admin::global_dictionary.create')->render();
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'keywords' => 'required|max:120|unique:global_keywords',
        ]);

        if (!$validator->fails()) {

            if( $keyword = GlobalDictionary::create($request->only('keywords')) ) {

                $client = new \GuzzleHttp\Client();
                $response = $client->post(
                    $this->scma_url.'globals',
                    [
                        'headers' => [
                            'Content-Type' => 'application/json',
                        ],
                        'json' => ['name' => $request->only('keywords')['keywords']],
                    ]
                );
                $response_body = $response->getBody();
                $response_arr = json_decode((string) $response_body);

                if($response->getStatusCode() == 200){
                    $keyword->external_id = $response_arr->data->id;
                    $keyword->save();
                    flash('Global Dictionary Added')->success();
                }
            }
            else {
                flash('Failed to create global dictionary.')->error();
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
        $dictionary = GlobalDictionary::find($id);
        return view('admin::global_dictionary.edit', compact('dictionary'))->render();
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
            'keywords' => 'required|max:120|unique:global_keywords',
        ]);

        if (!$validator->fails()) {
            
            $dictionary = GlobalDictionary::findOrFail($id);

            $dictionary->fill($request->only('keywords'));

            if($dictionary->save())
            {
                $client = new \GuzzleHttp\Client();
                $response = $client->post(
                    $this->scma_url.'globals/'.$dictionary->external_id,
                    [
                        'headers' => [
                            'Content-Type' => 'application/json',
                        ],
                        'json' => ['name' => $request->only('keywords')['keywords']],
                    ]
                );
                $response_body = $response->getBody();

                if($response->getStatusCode() == 200){
                    flash('Global dictionary has been updated.')->success();
                }else{
                    flash('ERROR - '.json_encode((string) $response_body))->error();
                }


                
            }
            else{
                flash('Global dictionary failed to update.')->error();
            }
        } 
        else {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        return redirect()->route('global_dictionary.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $keyword = GlobalDictionary::findOrFail($id);
        if( $keyword->delete() ) {

            $client = new \GuzzleHttp\Client();
            $response = $client->delete($this->scma_url.'globals/'.$keyword->external_id);
            if($response->getStatusCode() == 200){
                return 'success';
            }
        } else {
            return 'error';
        }
    }
}
