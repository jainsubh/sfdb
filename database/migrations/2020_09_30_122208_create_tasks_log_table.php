<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks_log', function (Blueprint $table) {
            $table->id();
            $table->text('description')->nullable()->collate('utf8mb4_unicode_ci');
            $table->unsignedBigInteger('task_id')->index();
            $table->foreign('task_id')->references('id')->on('tasks');
            $table->unsignedBigInteger('assigned_to')->index();
            $table->foreign('assigned_to')->references('id')->on('users');
            $table->unsignedBigInteger('assigned_by')->index();
            $table->foreign('assigned_by')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks_log');
    }
}
