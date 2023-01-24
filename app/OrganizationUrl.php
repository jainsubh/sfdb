<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class OrganizationUrl extends Model
{
    use Notifiable;
    use SoftDeletes;
    use LogsActivity;
    protected static $logName = 'organization_urls_log';
    protected $table = 'organization_urls';

    protected $fillable = [
        'name', 'url'
    ];
}
