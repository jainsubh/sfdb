<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Event;
use App\Departments;
use App\User;
use App\Alert;
use App\Sectors;
use App\CrawlLog;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Event extends Model
{
    use SoftDeletes;
    use LogsActivity;
    protected static $logName = 'events_log';
    protected $fillable = ['name','match_condition', 'external_id', 'sector_id', 'search_type','status','start_date','end_date','crawl_type', 'event_lock', 'created_by', 'modified_by'];

    public function sectors()
    {
        return $this->belongsTo(Sectors::class, 'sector_id', 'id');
    }

    public function alerts()
    {
        return $this->belongsTo(Alert::class, 'event_id', 'id');
    }

    public function departments()
    {
        return $this->belongsToMany(Departments::class);
    }
    
    public function eventdepartments(){

        return $this->hasMany(EventDepartment::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function created_by_user(){
        return $this->belongsTo(User::class, 'created_by')->withTrashed();
    }

    public function modified_by_user(){
        return $this->belongsTo(User::class, 'modified_by')->withTrashed();
    }

    public function eventuser(){
        return $this->hasMany(EventUser::class);
    }
    public function crawl_log(){
        return $this->hasOne(CrawlLog::class)->latest();
    }

    public function scopeOwn($query){
        $query->whereHas('eventuser', function ($query) {
            $query->whereLatest('user_id', auth()->user()->id);
        })->orWhere('created_by', auth()->user()->id);
    }

    public function scopeViewAs($query, $id=null){
        $query->whereHas('eventuser', function ($query) use ($id) {
            $query->whereLatest('user_id', $id);
        })->orWhere('created_by', $id);
    }

    public function scopeActive($query){
        return $query->where(['deleted_at' => null]);
    }

   
}
