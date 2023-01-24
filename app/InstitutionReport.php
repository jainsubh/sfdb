<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\Traits\LogsActivity;
use App\OrganizationUrl;

class InstitutionReport extends Model
{
    use Notifiable;
    use SoftDeletes;
    use HasRoles;
    use LogsActivity;
    protected static $logName = 'institution_reports_log';
    
    protected $fillable = [
        'name', 'institute_id', 'date_time', 'institution_report'
    ];

    public function organization(){
        return $this->belongsTo(OrganizationUrl::class, 'institute_id');
    }

    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function tasks(){
        return $this->morphOne(Tasks::class, 'subject')->withTrashed();
    }

    /**
     * Scope a query to only include active users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeArchive($query){
        return $query->where(['archive' => 1, 'deleted_at' => null]);
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
     * scopeOwn
     *
     * @param  mixed $query
     * @return void
     */
    public function scopeOwn($query){
        $query->whereHas('tasks', function($query){ 
            $query->whereHas('latest_task_log',  function($q){
                $q->where('assigned_to', auth()->user()->id);
            });
        })->orWheredoesnthave('tasks');
    }

    /**
     * Scope a query to only include active Institution Report.
     * Reports not archive and not deleted
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsLibrary($query){
        return $query->where('send_library', 1);
    }
}
