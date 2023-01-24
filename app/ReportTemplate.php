<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class ReportTemplate extends Model
{
    use Notifiable;
    use SoftDeletes;
    use LogsActivity;
    protected static $logName = 'report_template_logs';

    protected $fillable = ['name','type'];
}
