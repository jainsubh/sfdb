<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Alert;

class AlertTweets extends Model
{
    protected static $logName = 'alert_tweets_log';
    public $timestamps = FALSE;
    protected $fillable = ['tweets'];

    public function alerts()
    {
        return $this->belongsTo(Alert::class);
    }
}
