<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFullyManualLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fully_manual_links', function (Blueprint $table) {
            $table->id();
            $table->text('url')->charset('utf8')->collate('utf8_bin');
            $table->unsignedBigInteger('fully_manual_id');
            $table->foreign('fully_manual_id')
                ->references('id')
                ->on('fully_manual');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fully_manual_links');
    }
}
