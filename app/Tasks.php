<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Contracts\Activity;
use Illuminate\Http\Request;
use Carbon\Carbon;

class Tasks extends Model
{
    use SoftDeletes;

    protected $dates = ['completed_at'];
    protected $fillable = ['priority', 'status', 'completed_at', 'due_date'];

    public function task_log(){
        return $this->hasMany(Tasklog::class, 'task_id', 'id')->latest();
    }

    public function latest_task_log(){
        return $this->hasOne(Tasklog::class, 'task_id', 'id')->latest();
    }
    
    public function alert(){
        return $this->belongsTo(Alert::class, 'subject_id', 'id')->withTrashed();
    }

    public function report(){
        return $this->belongsTo(InstitutionReport::class, 'subject_id', 'id')->withTrashed();
    }

    public function external_report(){
        return $this->belongsTo(ExternalReport::class, 'subject_id', 'id')->withTrashed();
    }

    public function semi_automatic(){
        return $this->hasOne(SemiAutomatic::class, 'task_id', 'id')->withTrashed();
    }

    public function fully_manual(){
        return $this->hasOne(FullyManual::class, 'task_id', 'id');
    }

    public function product(){
        return $this->hasOne(Product::class, 'task_id', 'id');
    }

    public function subject(){
        return $this->morphTo()->withTrashed();
    }

    public function completed_by_user(){
        return $this->belongsTo(User::class, 'completed_by', 'id')->withTrashed();
    }

    public function scopeCreated($query){
        return $query->whereHas('description', function($status) {
            $status->where('status', 'Requested');
        });
    }

    public function scopeLatestTask($query, $type){
        $query->whereHas('task_log', function ($query) use ($type) {
            $query->whereLatest('description', $type);
        });
    }

    public function scopeOwn($query){
        $query->whereHas('task_log', function ($query) {
            $query->whereLatest('assigned_to', auth()->user()->id);
        });
    }

    public function scopeViewAs($query, $id){
        $query->whereHas('task_log', function ($query) use ($id) {
            $query->whereLatest('assigned_to', $id);
        });
    }

    public function scopeSemiAutoCompleted($query){
        $query->whereHas('semi_automatic', function ($query) {
            $query->whereLatest('status','complete');
        });
        $query->latest('updated_at')->latest('id');
    }
    
    public function scopeInProgress($query){
        $query->where('status', 'new');
    }

    public function scopeComplete($query){
        $query->where('status', 'complete');
    }

}
