<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    use SoftDeletes;
    protected $table = 'data';
    protected $fillable = ['name', 'dataset_id'];

    
}
