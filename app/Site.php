<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Departments;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Site extends Model
{
    use SoftDeletes;
    use LogsActivity;
    protected static $logName = 'sites_log';
    protected $fillable = ['company_name','company_url','crawl','crawl_interval','crawl_depth','site_color','site_type','selector','selector_value','external_id'];

    public function departments()
    {
        return $this->belongsToMany(Departments::class);
    }
}