<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Alert;

class AlertLinks extends Model
{
    protected static $logName = 'alert_links_log';
    public $timestamps = FALSE;
    protected $fillable = ['url'];

    public function alerts()
    {
        return $this->belongsTo(Alert::class);
    }
}
