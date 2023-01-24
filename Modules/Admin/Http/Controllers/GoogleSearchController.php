<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Config;
use DB;
use App\Alert;
use jainsubh\GoogleSearchApi\GoogleSearchApi;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

class GoogleSearchController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        try {
            $results = [];
            $paginator = [];

            if($request->has('search') && $request->search != ''){
                $googleSearch = new GoogleSearchApi(); // initialize
                
                $parameters = [
                    'cr' => 'countryAE',
                ];
                
                $results = $googleSearch->getResults($request->search, $parameters); // get first 10 results for query 'some phrase'
                $total_result = $googleSearch->getTotalNumberOfResults();

                $paginator = new Paginator($results, $total_result, 10, 1, [
                    'path'  => route('google_search.search_result'),
                    'query' => $request->query(),
                ]);
            }

            $alerts = Alert::doesnthave('tasks')->active()->latest('id')->paginate(15);
            $alerts->withPath(route('alerts.paginate_alert'));
            return view('google_search.index', compact('alerts', 'results', 'request', 'paginator'))->with('name', 'Google Search');
        } catch (Throwable $e) {
            return false;
        }

        
    }


    public function search_result(Request $request){
        $results = [];
        $paginator = [];

        if($request->has('search') && $request->search != ''){
            $googleSearch = new GoogleSearchApi(); // initialize

            $start = 1;
            if(isset($request->page)){
                $start = (($request->page-1)*10)+1;
            }

            $parameters = [
                'cr' => 'countryAE',
                'start' => $start,
            ];
            
            $results = $googleSearch->getResults($request->search, $parameters); // get first 10 results for query 'some phrase'
            $total_result = $googleSearch->getTotalNumberOfResults();

            $paginator = new Paginator($results, $total_result, 10, 1, [
                'path'  => route('google_search.search_result'),
                'query' => $request->query(),
            ]);
        }
    
        
        return view('google_search.search_result', compact('results', 'request', 'paginator'));
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
