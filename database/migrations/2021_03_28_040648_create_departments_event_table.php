<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentsEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments_event', function (Blueprint $table) {
            $table->unsignedBigInteger('departments_id')->index();
            $table->foreign('departments_id')->references('id')->on('departments')->onDelete('cascade');
            $table->unsignedBigInteger('event_id')->index();
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->primary(['departments_id', 'event_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('departments_event');
    }
}
