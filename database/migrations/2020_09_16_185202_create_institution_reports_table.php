<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstitutionReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('institution_reports', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('name', 1080)->collate('utf8_bin');
            $table->unsignedBigInteger('institute_id')->default(0);
            $table->index('institute_id'); 
            $table->foreign('institute_id')
                ->references('id')
                ->on('organization_urls')
                ->onDelete('cascade');
            $table->tinyInteger('type')->default(0)->comment('0 for Manual , 1 for automatic');
            $table->tinyInteger('send_library')->default(0)->comment('0 for not sent , 1 for sent');	
            $table->tinyInteger('archive')->default(0)->comment('0 for not archived , 1 for archived');	
            $table->timestamp('date_time')->default(DB::raw('CURRENT_TIMESTAMP'))->nullable();
            $table->string('institution_report')->unique();
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
        Schema::dropIfExists('institution_reports');
    }
}
