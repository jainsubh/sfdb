<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\EventsUsers;
use App\User;
use App\Event;

class EventUser extends Model
{
    public $table = 'event_user';
    public $timestamps = false;

    public $fillable = [
        'users_id'
    ];

    public function users(){
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public function events(){
        return $this->belongsTo(Event::class,'event_id','id');
    }
}
