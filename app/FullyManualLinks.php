<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FullyManualLinks extends Model
{
    protected static $logName = 'fully_manual_links_log';
    public $timestamps = false;
    protected $fillable = ['url'];

}
