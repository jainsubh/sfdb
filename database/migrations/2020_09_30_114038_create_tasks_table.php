<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->enum('priority',['low', 'medium','high'])->default('low')->collate('utf8_bin');
            $table->morphs('subject');
            $table->string('status')->default('new')->collate('utf8_bin')->comment('New - Task created | In Progress - Task has been started | Pending - Task transfered back to manager | Completed - Task has been completed.');
            $table->timestamp('completed_at')->nullable();
            $table->unsignedBigInteger('completed_by')->nullable()->index();
            $table->foreign('completed_by')->references('id')->on('users');
            $table->date('due_date')->nullable();
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
        Schema::dropIfExists('tasks');
    }
}
