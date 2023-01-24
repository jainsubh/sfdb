<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRunTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('run', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('location')->nullable();
            $table->foreign('location')
                ->references('id')
                ->on('location');
            $table->dateTime('time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('run');
    }
}
