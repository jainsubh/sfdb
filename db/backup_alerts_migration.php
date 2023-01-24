<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alerts', function (Blueprint $table) {
            $table->id();
            $table->string('title', 250)->collation('utf8_general_ci');
            $table->text('summary')->collation('utf8_general_ci');
            $table->bigInteger('sector_id')->nullable()->unsigned()->index();
            $table->foreign('sector_id')->references('id')->on('sectors');
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
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
        Schema::dropIfExists('alerts');
    }
}
