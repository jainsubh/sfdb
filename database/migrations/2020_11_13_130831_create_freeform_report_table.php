<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFreeformReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('freeform_report', function (Blueprint $table) {
            $table->id();
            $table->string('ref_id')->unique();
            $table->string('title')->collate('utf8_bin');
            $table->string('objective')->collate('utf8_bin')->nullable();
            $table->text('key_information')->nullable();
            $table->enum('priority',['low', 'medium','high'])->default('low')->collate('utf8_bin');
            $table->unsignedBigInteger('sector_id')->index()->nullable();
            $table->foreign('sector_id')->references('id')->on('sectors');
            $table->enum('status',['progress', 'transfer', 'complete'])->default('progress');
            $table->unsignedBigInteger('assigned')->index();
            $table->foreign('assigned')->references('id')->on('users');
            $table->tinyInteger('archive')->default(0)->comment('0 for not archived , 1 for archived');	
            $table->tinyInteger('send_library')->default(0)->comment('0 for not sent , 1 for sent');	
            $table->timestamp('date_time')->default(DB::raw('CURRENT_TIMESTAMP'))->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement("ALTER TABLE `freeform_report` CHANGE `key_information` `key_information` LONGBLOB NULL DEFAULT NULL");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('freeform_report');
    }
}
