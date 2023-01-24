<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Event;
use App\Departments;

class EventDepartment extends Model
{
    protected $table = 'departments_event';
    public $timestamps = false;

    protected $fillable = [
        'departments_id'
    ];

    public function departments(){
        return $this->belongsTo(Departments::class, 'departments_id', 'id');
    }

    public function events(){
        return $this->belongsTo(Event::class,'event_id','id');
    }

}
