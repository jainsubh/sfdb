<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddObjectiveToSemiAutomaticTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('semi_automatic', function (Blueprint $table) {
            
            $table->string('objective')->collate('utf8_bin')->nullable()->after('key_information');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('semi_automatic', function (Blueprint $table) {
            //
        });
    }
}
