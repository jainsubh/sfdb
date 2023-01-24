<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Data;

class Dataset extends Model
{
    use SoftDeletes;
    protected $table = 'dataset';
    protected $fillable = ['name'];

    public function data(){
        return $this->hasMany(Data::class);
    }

    public function datasetWithData($dataset){
        $dataset_map = $dataset->map(function($data_val, $value){
            return $data_val->data->pluck('name', 'id');
        })->values()->toarray();

        $dataset_arr = $dataset->toarray();

        foreach($dataset_arr as $dataset_key => $dataset_value){
            $dataset_arr[$dataset_key]['data'] =  $dataset_map[$dataset_key];
        }

        return $dataset_arr;
    }
}
