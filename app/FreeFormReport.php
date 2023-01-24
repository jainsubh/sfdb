<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Sectors;
use App\User;

class FreeFormReport extends Model
{
    use SoftDeletes;
    use LogsActivity;
    protected static $logName = 'freeform_reports_log';
    protected $table = 'freeform_report';

    protected $fillable = [
        'ref_id','title', 'objective', 'key_information', 'recommendation','priority','sector_id','assigned','thumbnail','date_time'
    ];

    public function sectors()
    {
        return $this->belongsTo(Sectors::class,'sector_id','id');
    }
    public function users()
    {
        return $this->belongsTo(User::class,'assigned','id');
    }

    public function tasks(){
        return $this->morphOne(Tasks::class, 'subject')->withTrashed();
    }

    public function data(){
        return $this->morphToMany(Data::class, 'subject', 'dataset_data')->using(DatasetData::class);
    }

    public function report_countries(){
        return $this->morphMany(ReportCountry::class, 'subject');
    }

    public function scopeOwn($query){
        $query->where('assigned',  auth()->user()->id);
    }
    
    public function scopeHasCompleted($query){
        $query->where('status', 'complete');
    }

    public function scopeActive($query){
        return $query->where(['archive' => 0, 'deleted_at' => null]);
    }
    
    public function scopeIsLibrary($query){
        return $query->where('send_library', 1);
    }

    public function scopeArchive($query){
        return $query->where(['archive' => 1, 'deleted_at' => null]);
    }
}
