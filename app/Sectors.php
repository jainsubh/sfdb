<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Sectors extends Model
{
    use SoftDeletes;
    use LogsActivity;
    protected static $logName = 'sectors_log';
    protected $fillable = ['name'];

    public function alerts(){
        return $this->hasMany(Alert::class, 'sector_id', 'id')->latest();
    }

    public function freeform_reports(){
        return $this->hasMany(FreeFormReport::class, 'sector_id', 'id')->latest();
    }
}
