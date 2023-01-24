<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use App\Authorizable;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Alert;
Use App\InstitutionReport;
Use App\Run;
Use App\Trend;
use App\Tasks;
use App\AlertCountry;
use App\Sectors;
use App\Site;
use App\Event;
use App\OrganizationUrl;
use App\AlertKeywords;
use App\GlobalDictionary;
use DB;

class MasterController extends Controller {

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index() {
        //DB::enableQueryLog(); // Enable query log
        //dd(DB::getQueryLog()); // Show results of log
        $alert_country = AlertCountry::selectRaw('country_id, count(*) AS total')->with('country')->groupBy('country_id')->orderBy('total', 'desc')->limit(8)->get();
        
        //$alert_keyword = AlertKeywords::selectRaw('DISTINCT keyword, count(id) AS total')->groupBy('keyword')->orderBy('total', 'desc')->limit(16)->get();
        
        //dd($alert_keyword);
        //$alert_country = [];
        //$alert_keyword = [];
        
        
        
        $alerts = Alert::doesnthave('tasks')->active()->latest()->take(30)->get();
        /*
        $institution_report = [];
        $institution_report_count = array("institution_report_total" => 0, "institution_report_year" => 0, "institution_report_month" => 0);
        */

        
        
        $institution_report = InstitutionReport::active()->orderBy('created_at', 'desc')->limit(8)->get();
        $institution_report = $institution_report->toArray();
        $institution_report_total = InstitutionReport::count();
        $institution_report_month = InstitutionReport::whereMonth('date_time', date('m'))->count();
        $institution_report_year = InstitutionReport::whereYear('date_time', date('Y'))->count();
        $institution_report_count = array("institution_report_total" => $institution_report_total, "institution_report_year" => $institution_report_year, "institution_report_month" => $institution_report_month);
        
        

        $analyst_report = Tasks::with(['subject'])->complete()->orderBy('completed_at', 'desc')->get();
        $analyst_report_count = count($analyst_report);
        $analyst_report_month = Tasks::whereMonth('created_at', date('m'))->complete()->get();
        $analyst_report_month = count($analyst_report_month->toArray());
        $analyst_report_year = Tasks::whereYear('created_at', date('Y'))->complete()->get();
        $analyst_report_year = count($analyst_report_year->toArray());
        
        
        $global_trends_report = '';
        $global_trends_total = '';
        $uae_trends_report = '';
        $uae_trends_total = '';

        // Fetching monitoring details from API
        $curl = curl_init();
        $monitoring_details = null;

        curl_setopt_array($curl, array(
            CURLOPT_URL => config('scma.url')."crawl_logs",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        $monitoring_details = json_decode($response, true);
        if($monitoring_details != null){
            $monitoring_details = $monitoring_details['data'];
        }
        curl_close($curl);
        
        //Count Monitoring Details and Sectors Section
        $count['site'] = Site::count();
        $count['organisation'] = OrganizationUrl::count();
        $event_keywords = Event::pluck('keywords');
        $global_keywords = GlobalDictionary::pluck('keywords')->toArray();
        $event_keyword = [];
        foreach($event_keywords as $key=>$value){
            $event_keyword = array_unique(array_merge($event_keyword, explode(",",$value)));
        }
        $count['keywords'] = count(array_unique(array_merge($event_keyword, $global_keywords)));
        
        $sectors = Sectors::limit(6)->pluck('name');
        //Count Monitoring Details and Sectors Section
        
        $world_id = Run::where('location', 1)->orderBy('id', 'desc')->first();
        if($world_id){
            $global_trends_report = Trend::where('run',$world_id->id)->orderBy('volume','desc')->get();
            $global_trends_total = Trend::where('run',$world_id->id)->get()->sum("volume");
        }
        
        
        $uae_id = Run::where('location', 23424738)->orderBy('id', 'desc')->first();
        if($uae_id){
            $uae_trends_report = Trend::where('run',$uae_id->id)->orderBy('volume','desc')->get();
            $uae_trends_total = Trend::where('run',$uae_id->id)->get()->sum("volume");
        }
        
        return view('master', compact('monitoring_details','sectors','count','institution_report', 'institution_report_count', 'analyst_report', 'analyst_report_count', 'analyst_report_month', 'analyst_report_year', 'alerts', 'global_trends_report', 'uae_trends_report', 'global_trends_total', 'uae_trends_total', 'alert_country'))->with('name', 'STRATEGIC FORESIGHT DASHBOARD');
    }

    public function alert_keyword(){
        $alert_keyword = AlertKeywords::selectRaw('DISTINCT keyword, count(id) AS total')->groupBy('keyword')->orderBy('total', 'desc')->limit(16)->get();
        return view('master.alert_keyword', compact('alert_keyword'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create() {
        return view('admin::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request) {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id) {
        return view('admin::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id) {
        return view('admin::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id) {
        //
    }

    public function institution_report() {
        $institution_report = InstitutionReport::where('send_library', 1)->orderBy('created_at', 'desc')->paginate(15);
        return view('master', compact('institution_report'))->with('name', 'master dashboard');
    }

    public function get_mapvalues() {
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => config('constants.ftrss.url'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);

        $result = json_decode($response, true);
        curl_close($curl);

        echo json_encode($result['data'], true);
        exit();
    }
    

}
