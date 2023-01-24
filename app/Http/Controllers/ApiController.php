<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Tasks;
use Carbon\Carbon;


class ApiController extends Controller
{  
    public function completed_reports(Request $request)
    {
        try{
            $date = Carbon::now()->subDays(7);
            $tasks_completed = Tasks::complete()->with(['subject', 'latest_task_log.assigned_to_user', 'latest_task_log.assigned_by_user', 'semi_automatic', 'fully_manual', 'product', 'completed_by_user'])->whereHasMorph('subject',['App\FreeFormReport', 'App\Tasks', 'App\InstitutionReport', 'App\ExternalReport', 'App\Product','App\Alert'])->latest('updated_at')->where('updated_at', '>=', $date)->get();
            
            $completed_reports = [];
            if(count($tasks_completed) > 0){
                foreach($tasks_completed as $task){
                    if($task->semi_automatic && $task->semi_automatic->status == 'complete'){
                        $completed_reports[] = array(
                            'guid' => $task->semi_automatic->ref_id,
                            'title' => $task->subject->title,
                            'link' => route('semi_automatic.download', $task->semi_automatic->ref_id),
                            'createdBy' => $task->completed_by_user->name,
                            'pubDate' => $task->completed_at->toRssString()
                        );
                    }  
                    if($task->fully_manual && $task->fully_manual->status == 'complete') {
                        $completed_reports[] = array(
                            'guid' => $task->fully_manual->ref_id,
                            'title' => $task->fully_manual->title,
                            'link' => route('fully_manual.download', $task->fully_manual->ref_id),
                            'createdBy' => $task->completed_by_user->name,
                            'pubDate' => $task->completed_at->toRssString()
                        );
                    }  
                    if($task->subject_type == 'freeform_report' && $task->subject->status == 'complete') {
                        $completed_reports[] = array(
                            'guid' => $task->subject->ref_id,
                            'title' => $task->subject->title,
                            'link' => route('freeform_report.download', $task->subject->ref_id),
                            'createdBy' => $task->completed_by_user->name,
                            'pubDate' => $task->completed_at->toRssString()
                        );
                    }  
                    if($task->product && $task->product->status == 'complete') {
                        $completed_reports[] = array(
                            'guid' => $task->product->ref_id,
                            'title' => $task->product->title,
                            'link' => route('product.download', $task->product->ref_id),
                            'createdBy' => $task->completed_by_user->name,
                            'pubDate' => $task->completed_at->toRssString()
                        );
                    }
                }
            }
            
            return response()->json($completed_reports);
        }catch(ModelNotFoundException $e){
            abort(404);
        }   
    }
}