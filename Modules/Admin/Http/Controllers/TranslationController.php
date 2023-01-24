<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Routing\Controller;
use App\Alert;
use Illuminate\Support\Facades\Validator;
use Config;

class TranslationController extends Controller
{
    public $traslate_api;
    public $default_header;

    public function __construct(){
        $this->traslate_api = Config::get('translate.url');
        $this->default_header = [
            'Content-Type' => 'application/json',
        ];
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $alerts = Alert::doesnthave('tasks')->active()->latest('id')->paginate(15);
        $alerts->withPath(route('alerts.paginate_alert'));
        return view('translation.index')->with('name', 'Language Translator');
    }
    
    /**
     * translate
     *
     * @param  mixed $request
     * @return void
     */
    public function translate(Request $request){
        parse_str($request->input('data'), $request);
        
        $messages = [
            'translateFrom.required' => 'Select Translate From',
            'translateTo.required' => 'Select Translate To',
            'translateFromText.required' => 'Please enter Some text to translate'
        ];

        $rules = [
            'translateFrom' => 'required',
            'translateTo' => 'required',
            'translateFromText' => 'required'
        ];

        //$validator = $request->validate($rules, $messages);
        $validator = Validator::make($request, $rules, $messages);

        if ($validator->fails()){
            return response()->json($validator->errors()->first(), 404);
        }
        else{

            $source = $request['translateFrom'];
            $target = $request['translateTo'];
            $sourceText = $request['translateFromText'];

            $response = Http::accept('application/json')->post($this->traslate_api, [
                'q' => $sourceText,
                'source'=> $source,
                'target'=> $target,
                'format'=> 'text'
            ])->json();

            $targetText = $response['translatedText'];

            if($targetText){ 
                return response()->json([
                    'status'=> 'Success',
                    'message' => 'Translated successfully',
                    'data' => $targetText
                ], 200);
            }else{
                return response()->json('Error in Translating', 404);
            }
        }
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
        //
    }
}
