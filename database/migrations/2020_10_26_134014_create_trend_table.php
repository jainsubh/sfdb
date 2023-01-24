<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrendTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trend', function (Blueprint $table) {
            $table->id();
            $table->mediumText('value')->collate('utf8_general_ci')->nullable();
            $table->integer('place')->nullable();
            $table->integer('volume')->nullable();
            $table->unsignedBigInteger('run')->nullable();
            $table->foreign('run')
                ->references('id')
                ->on('run');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trend');
    }
}
