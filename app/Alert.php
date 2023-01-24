<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Alert extends Model
{
    use SoftDeletes;
    use LogsActivity;

    protected static $logName = 'alert_log';

    protected $fillable = ['title','objective','summary', 'recommendation','postive','neutral','negative','user_id','event_id','sector_id','department_id','archive','assigned','due_date'];

    public function keywords(){
        return $this->hasMany(AlertKeywords::class);
    }

    public function links(){
        return $this->hasMany(AlertLinks::class);
    }

    public function comments(){
        return $this->hasMany(AlertComments::class);
    }

    public function tweets(){
        return $this->hasMany(AlertTweets::class);
    }

    public function countries(){
        return $this->hasMany(AlertCountry::class);
    }

    public function events(){
        return $this->hasOne(Event::class,'id','event_id');
    }

    public function users(){
        return $this->hasOne(User::class,'id','user_id');
    }

    public function sectors(){
        return $this->hasOne(Sectors::class,'id', 'sector_id');
    }

    public function gallery(){
        return $this->hasMany(AlertGallery::class);
    }

    public function tasks(){
        return $this->morphOne(Tasks::class, 'subject')->withTrashed();
    }

    public function scopeOwnAlerts($query){
       $query->whereHas('events', function ($query) {
            $query->where('created_by', auth()->user()->id);
        })->orwhereHas('events', function ($query) {
            $query->WhereHas('eventuser', function ($q){
                $q->where('user_id', auth()->user()->id);
            });
        });
    }

    public function scopeArchive($query){
        return $query->where(['archive' => 1, 'deleted_at' => null]);
    }

    public function scopeActive($query){
        return $query->where(['archive' => 0, 'deleted_at' => null]);
    }

    public function scopeOwn($query){
        $query->whereHas('tasks', function($query){ 
            $query->whereHas('latest_task_log',  function($q){
                $q->where('assigned_to', auth()->user()->id);
            });
        })->orWheredoesnthave('tasks');
    }
}
