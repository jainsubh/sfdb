<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToFullyManualTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fully_manual', function (Blueprint $table) {
            $table->text('key_information')->nullable()->after('summary');
            $table->text('recommendation')->nullable()->after('key_information');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fully_manual', function (Blueprint $table) {
            //
        });
    }
}
