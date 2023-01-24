<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductGallery extends Model
{
    protected $table = 'product_gallery';
    public $timestamps = false;

    protected $fillable = ['images'];
}
