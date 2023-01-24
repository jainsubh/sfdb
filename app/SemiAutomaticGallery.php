<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SemiAutomaticGallery extends Model
{
    protected $table = 'semi_automatic_gallery';
    public $timestamps = false;

    protected $fillable = ['images'];
}
