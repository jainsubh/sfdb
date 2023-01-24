<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Product extends Model
{
    use SoftDeletes;
    use LogsActivity;

    protected static $logName = 'product_log';
    protected $table = 'product';
    protected $fillable = ['ref_id', 'type','status', 'report_by', 'task_id', 'sector_id', 'priority', 'objectives', 'date_time', 'title', 'summary', 'features', 'negatives', 'advantages', 'vendor_information'];

    public function task(){
        return $this->belongsTo(Tasks::class);
    }

    public function sectors(){
        return $this->belongsTo(Sectors::class, 'sector_id');
    }

    public function reported_by(){
        return $this->belongsTo(User::class, 'report_by')->withTrashed();
    }

    public function gallery(){
        return $this->hasMany(ProductGallery::class);
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
