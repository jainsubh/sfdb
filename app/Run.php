<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Run extends Model
{
    
    protected $table = 'run';
    
    protected $fillable = [
        'location'
    ];


}
