<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class FullyManual extends Model
{
    use SoftDeletes;
    use LogsActivity;

    protected static $logName = 'fully_manual_log';
    protected $table = 'fully_manual';
    protected $fillable = ['ref_id', 'type','status', 'report_by', 'task_id', 'sector_id', 'priority', 'objectives', 'date_time', 'title', 'summary', 'features', 'negatives', 'advantages', 'vendor_information','key_information','recommendation'];

    public function task(){
        return $this->belongsTo(Tasks::class);
    }

    public function links(){
        return $this->hasMany(FullyManualLinks::class);
    }

    public function sectors(){
        return $this->belongsTo(Sectors::class, 'sector_id');
    }

    public function gallery(){
        return $this->hasMany(FullyManualGallery::class);
    }

    public function reported_by(){
        return $this->belongsTo(User::class, 'report_by')->withTrashed();
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

    public function scopeArchive($query){
        return $query->where(['archive' => 1, 'deleted_at' => null]);
    }
}
