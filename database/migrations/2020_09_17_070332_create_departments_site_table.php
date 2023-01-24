<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentsSiteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments_site', function (Blueprint $table) {
            $table->unsignedBigInteger('departments_id')->index();
            $table->foreign('departments_id')->references('id')->on('departments')->onDelete('cascade');
            $table->unsignedBigInteger('site_id')->index();
            $table->foreign('site_id')->references('id')->on('sites')->onDelete('cascade');
            $table->primary(['departments_id', 'site_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('departments_site');
    }
}
