<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Country extends Model
{
    protected static $logName = 'countries_log';
    public $timestamps = FALSE;
    
    protected $fillable = ['country_name','city','longitude','latitude','country_code2','country_code3','capital'];
}
