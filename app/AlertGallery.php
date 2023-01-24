<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlertGallery extends Model
{
    protected $table = 'alert_gallery';
    public $timestamps = false;

    protected $fillable = ['images'];
}
