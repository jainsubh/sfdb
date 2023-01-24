<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tasklog extends Model
{
    protected $table = "tasks_log";

    protected $fillable = ['log_name', 'description', 'task_id', 'assigned_to', 'assigned_by'];

    public function Tasks(){
        return $this->belongsTo(Tasks::class, 'task_id');
    }

    public function assigned_to_user(){
        return $this->belongsTo(User::class, 'assigned_to')->withTrashed();
    }

    public function assigned_by_user(){
        return $this->belongsTo(User::class, 'assigned_by')->withTrashed();
    }
}
