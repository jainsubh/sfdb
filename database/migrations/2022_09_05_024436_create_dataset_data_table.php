<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatasetDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dataset_data', function (Blueprint $table) {
            $table->id();
            $table->morphs('subject');
            $table->unsignedBigInteger('dataset_id')->nullable()->index();
            $table->foreign('dataset_id')->references('id')->on('dataset');
            $table->unsignedBigInteger('data_id')->nullable()->index();
            $table->foreign('data_id')->references('id')->on('data');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dataset_data');
    }
}
