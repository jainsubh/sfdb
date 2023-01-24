<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FullyManualGallery extends Model
{
    protected $table = 'fully_manual_gallery';
    public $timestamps = false;

    protected $fillable = ['images'];
}
