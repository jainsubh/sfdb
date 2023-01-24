<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class GlobalDictionary extends Model
{
    use Notifiable;
    use SoftDeletes;
    use LogsActivity;
    protected static $logName = 'global_keywords_log';
    protected $table = 'global_keywords';

    protected $fillable = ['keywords'];
}
