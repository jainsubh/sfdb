<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExternalReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('external_reports', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique()->collate('utf8_bin');
            $table->string('organization_name')->collate('utf8_bin');
            $table->string('organization_url')->nullable()->collate('utf8_bin');
            $table->text('comments')->collate('utf8_bin'); 
            $table->string('external_report')->unique();
            $table->tinyInteger('send_library')->default(1)->comment('0 for not sent , 1 for sent');	
            $table->tinyInteger('archive')->default(0)->comment('0 for not archived , 1 for archived');
            $table->unsignedBigInteger('uploaded_by')->nullable()->index();
            $table->foreign('uploaded_by')->references('id')->on('users');
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
        Schema::dropIfExists('external_reports');
    }
}
