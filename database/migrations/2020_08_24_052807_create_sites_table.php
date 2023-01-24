<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sites', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->unique()->collate('utf8_bin');
            $table->string('company_url');
            $table->integer('crawl_interval');
            $table->integer('crawl_depth');
            $table->string('site_color');
            $table->string('site_type');
            $table->string('selector')->nullable();
            $table->string('selector_value')->nullable();
            $table->integer('external_id')->nullable();
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
        Schema::dropIfExists('sites');
    }
}
