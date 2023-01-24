<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = "location";   
    protected $fillable = ['id','value'];
    public $timestamps = FALSE;
}
