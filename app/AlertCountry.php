<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Alert;
use App\Country;

class AlertCountry extends Model
{
    protected static $logName = 'alert_countries_log';
    public $timestamps = FALSE;

    public function country(){
        return $this->belongsTo(Country::class,'country_id','id');
    }

    public function alerts()
    {
        return $this->belongsTo(Alert::class);
    }
}
