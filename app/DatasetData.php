<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphPivot; 

class DatasetData extends MorphPivot
{
    protected $table = 'dataset_data';
    protected $fillable = ['dataset_id', 'data_id'];
    public $timestamps = false;

    /**
     * Get all of the posts that are assigned this tag.
     */
    public function freeform_report()
    {
        return $this->morphedByMany(FreeFormReport::class, 'subject');
    }
}
