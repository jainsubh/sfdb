<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationUrlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_urls', function (Blueprint $table) {
            $table->id();
            $table->string('name')->collate('utf8_bin');
            $table->string('url')->unique()->collate('utf8_bin');
            $table->tinyInteger('download')->default(0)->comment('0 not download , 1 downlad');
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
        Schema::dropIfExists('organization_urls');
    }
}
