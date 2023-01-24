<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class SemiAutomatic extends Model
{
    use SoftDeletes;
    use LogsActivity;

    protected static $logName = 'semi_automatic_log';
    protected $table = 'semi_automatic';
    protected $fillable = ['ref_id', 'key_information', 'recommendation','objective','status', 'report_by', 'task_id', 'subject_id'];

    public function tasks(){
        return $this->belongsTo(Tasks::class,'task_id','id');
    }

    public function reported_by(){
        return $this->belongsTo(User::class, 'report_by')->withTrashed();
    }

    public function alert(){
        return $this->belongsTo(Alert::class, 'subject_id')->withTrashed();
    }

    public function gallery(){
        return $this->hasMany(SemiAutomaticGallery::class);
    }

    public function scopeHasCompleted($query){
        $query->where('status', 'complete');
    }

    public function scopeInProgress($query){
        $query->where('status', 'progress');
    }

    public function scopeOwn($query){
        $query->where('report_by', auth()->user()->id);
    }

    public function scopeIsActive($query){
        $query->where('archive', 0);
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
}
