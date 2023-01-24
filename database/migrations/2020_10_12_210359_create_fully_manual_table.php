<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFullyManualTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fully_manual', function (Blueprint $table) {
            $table->id();
            $table->string('ref_id')->unique();
            $table->enum('status',['progress','transfer', 'complete'])->default('progress');
            $table->enum('type', ['institution_report', 'alert','freeform_report','external_report'])->collate('utf8_bin');
            $table->tinyInteger('archive')->default(0)->comment('0 for not archived , 1 for archived');
            $table->unsignedBigInteger('report_by')->index();
            $table->foreign('report_by')->references('id')->on('users');
            $table->unsignedBigInteger('task_id')->index();
            $table->foreign('task_id')->references('id')->on('tasks');
            $table->unsignedBigInteger('sector_id')->unsigned()->nullable();
            $table->foreign('sector_id')
                ->references('id')
                ->on('sectors')->onDelete('set null');
            $table->enum('priority',['low', 'medium','high'])->default('low')->collate('utf8_bin');
            $table->string('objectives')->nullable();
            $table->timestamp('date_time')->default(DB::raw('CURRENT_TIMESTAMP'))->nullable();
            $table->string('title')->nullable();
            $table->text('summary')->nullable();
            $table->text('features')->nullable();
            $table->text('negatives')->nullable();
            $table->text('advantages')->nullable();
            $table->text('vendor_information')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('fully_manual_gallery', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('images')->collate('utf8_bin');
            $table->unsignedBigInteger('fully_manual_id');
            $table->foreign('fully_manual_id')
                ->references('id')
                ->on('fully_manual');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fully_manual_gallery');
        Schema::dropIfExists('fully_manual_links');
        Schema::dropIfExists('fully_manual');
    }
}
