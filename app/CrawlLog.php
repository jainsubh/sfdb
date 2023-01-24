<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class CrawlLog extends Model
{
    use LogsActivity;
    protected static $logName = 'crawl_log';
    protected $table = 'crawl_log';
    public $timestamps = True;

    protected $fillable = ['event_id', 'status', 'no_of_sites', 'site_completed', 'completed_at', 'external'];

    public function Events(){
        return $this->belongsTo(Events::class, 'event_id');
    }
}
