<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Alert;
use App\User;
use Spatie\Activitylog\Traits\LogsActivity;

class AlertComments extends Model
{
    
    use LogsActivity;
    protected static $logName = 'comment_log';
   
    protected $fillable = ['comments','user_id','alert_id'];

    public function alerts()
    {
        return $this->belongsTo(Alert::class);
    }
    public function users()
    {
        return $this->belongsTo(User::class,'user_id','id')->withTrashed();
    }
    
}
