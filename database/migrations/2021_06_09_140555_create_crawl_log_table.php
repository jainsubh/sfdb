<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrawlLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crawl_log', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id')->index();
            $table->foreign('event_id')->references('id')->on('events');
            $table->enum('status',['in_queue', 'in_progress', 'complete'])->default('in_queue')->collate('utf8_bin');
            $table->unsignedBigInteger('no_of_sites')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crawl_log');
    }
}
