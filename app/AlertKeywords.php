<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Alert;

class AlertKeywords extends Model
{
    protected static $logName = 'alert_keywords_log';
    public $timestamps = FALSE;
    protected $fillable = ['keyword'];
    
    protected $maps = ['id' => 'keyword'];

    public function alerts()
    {
        return $this->belongsTo(Alert::class);
    }
}
