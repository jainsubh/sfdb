<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSemiAutomaticTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('semi_automatic', function (Blueprint $table) {
            $table->id();
            $table->string('ref_id')->unique();
            $table->text('key_information')->nullable();
            $table->enum('status',['progress', 'transfer', 'complete'])->default('progress');
            $table->tinyInteger('archive')->default(0)->comment('0 for not archived , 1 for archived');
            $table->unsignedBigInteger('report_by')->index();
            $table->foreign('report_by')->references('id')->on('users');
            $table->unsignedBigInteger('task_id')->index();
            $table->foreign('task_id')->references('id')->on('tasks');
            $table->unsignedBigInteger('subject_id')->index();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('semi_automatic_gallery', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('images')->collate('utf8_bin');
            $table->unsignedBigInteger('semi_automatic_id');
            $table->foreign('semi_automatic_id')
                ->references('id')
                ->on('semi_automatic');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('semi_automatic_gallery');
        Schema::dropIfExists('semi_automatic');
    }
}
