<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportCountry extends Model
{
    protected $table = 'report_countries';
    protected $fillable = ['country_id'];
    public $timestamps = false;

    public function subject(){
        return $this->morphTo();
    }

    public function country(){
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }
}
