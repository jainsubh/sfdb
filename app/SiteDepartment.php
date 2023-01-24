<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Event;
use App\Site;

class SiteDepartment extends Model
{
    protected $table = 'departments_site';
    public $timestamps = false;

    public function departments(){
        return $this->belongsTo(Departments::class,'departments_id','id');
    }

    public function sites()
    {
        return $this->belongsTo(Site::class,'site_id','id');
    }
}
