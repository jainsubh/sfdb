<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSiteCompleteFieldToCrawlLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('crawl_log', function (Blueprint $table) {
            $table->unsignedBigInteger('site_completed')->default(0)->after('no_of_sites')->comments('Number of sites crawl')->collate('utf8_bin');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('crawl_log', function (Blueprint $table) {
            //
        });
    }
}
