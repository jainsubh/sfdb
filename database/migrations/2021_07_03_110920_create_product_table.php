<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->string('ref_id')->unique();
            $table->enum('status',['progress','transfer', 'complete'])->default('progress');
            $table->enum('type', ['institution_report', 'alert','freeform_report','external_report'])->collate('utf8_bin');
            $table->tinyInteger('archive')->default(0)->comment('0 for not archived , 1 for archived');
            $table->unsignedBigInteger('report_by')->index();
            $table->foreign('report_by')->references('id')->on('users');
            $table->unsignedBigInteger('task_id')->index();
            $table->foreign('task_id')->references('id')->on('tasks');
            $table->enum('priority',['low', 'medium','high'])->default('low')->collate('utf8_bin');
            $table->unsignedBigInteger('sector_id')->unsigned()->nullable();
            $table->foreign('sector_id')
                ->references('id')
                ->on('sectors')->onDelete('set null');
            $table->timestamp('date_time')->default(DB::raw('CURRENT_TIMESTAMP'))->nullable();
            $table->string('title')->nullable();
            $table->string('objectives')->nullable();
            $table->text('features')->nullable();
            $table->text('negatives')->nullable();
            $table->text('advantages')->nullable();
            $table->text('vendor_information')->nullable();
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
        Schema::dropIfExists('product_gallery');
        Schema::dropIfExists('product');
    }
}
