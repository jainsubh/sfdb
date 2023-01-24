<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Site;
use App\Event;

class Departments extends Model
{
    use SoftDeletes;

    use LogsActivity;
    protected static $logName = 'departments_log';

    protected $fillable = ['name'];

    public function sites()
    {
        return $this->belongsToMany(Site::class);
    }

    public function events()
    {
        return $this->belongsToMany(Event::class);
    }
}
