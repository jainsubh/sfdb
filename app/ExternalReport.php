<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;
use Spatie\Activitylog\Traits\LogsActivity;

class ExternalReport extends Model
{
    use SoftDeletes;
    use LogsActivity;
    protected static $logName = 'external_reports_log';
    protected $table = 'external_reports';
    
    protected $fillable = [
        'title', 'organization_name', 'organization_url', 'type', 'comments', 'external_report','uploaded_by'
    ];
    
    public function users()
    {
        return $this->belongsTo(User::class,'uploaded_by','id');
    }

    public function tasks(){
        return $this->morphOne(Tasks::class, 'subject')->withTrashed();
    }


    /**
     * Scope a query to only include active Institution Report.
     * Reports not archive and not deleted
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query){
        return $query->where(['archive' => 0, 'deleted_at' => null]);
    }
    
    /**
     * scopeExternalReport
     *to fetch only reports that are type External
     * @param  mixed $query
     * @return void
     */
    public  function scopeExternalReport($query){
        return $query->where(['type' => 'external']);
    }
     
    /**
     * scopeScenarioReport
     * to fetch only reports that are type Scenario
     * @param  mixed $query
     * @return void
     */
    public  function scopeScenarioReport($query){
        return $query->where(['type' => 'scenario']);
    }
    
    /**
     * scopeIsLibrary
     *
     * @param  mixed $query
     * @return void
     */
    public function scopeIsLibrary($query){
        return $query->where('send_library', 1);
    }
        
    /**
     * scopeOwn
     *
     * @param  mixed $query
     * @return void
     */
    public function scopeOwn($query){
        $query->where('uploaded_by',  auth()->user()->id);
    }
    
    /**
     * scopeOwn
     *
     * @param  mixed $query
     * @return void
     */
    public function scopeOwnTasks($query){
        $query->whereHas('tasks', function($query){ 
            $query->whereHas('latest_task_log',  function($q){
                $q->where('assigned_to', auth()->user()->id);
            });
        })->orWheredoesnthave('tasks');
    }
    /**
     * scopeArchive
     *
     * @param  mixed $query
     * @return void
     */
    public function scopeArchive($query){
        return $query->where(['archive' => 1, 'deleted_at' => null]);
    }
    
}
