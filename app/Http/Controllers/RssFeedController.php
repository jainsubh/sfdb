<?php

namespace App\Http\Controllers;

use App\Tasks;
//use DB;
use Illuminate\Http\Request;

class RssFeedController extends Controller
{
    public function generate_rss_feed(Request $request)
    {
        try{
            $tasks_completed = Tasks::complete()->with(['subject', 'latest_task_log.assigned_to_user', 'latest_task_log.assigned_by_user', 'semi_automatic', 'fully_manual', 'product', 'completed_by_user'])->whereHasMorph('subject',['App\FreeFormReport', 'App\Tasks', 'App\InstitutionReport', 'App\ExternalReport', 'App\Product','App\Alert'])->latest('updated_at')->get();
        }catch(ModelNotFoundException $e){
            abort(404);
        }
        return response()->view('feed', compact('tasks_completed'))->header('Content-Type', 'application/xml');

    }
}