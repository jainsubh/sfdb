<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->collate('utf8_bin');
            $table->string('keywords')->nullable();
            $table->integer('external_id')->nullable();
            $table->unsignedBigInteger('sector_id')->index();
            $table->foreign('sector_id')->references('id')->on('sectors');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('events');
        Schema::dropIfExists('event_user');
        Schema::dropIfExists('departments_event');
        Schema::enableForeignKeyConstraints();
    }
}
