<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePdfTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pdf', function (Blueprint $table) {
            $table->id();
            $table->text('value');
            $table->timestamp('time')->useCurrent();
            $table->text('pdf_file');
            $table->text('txt_file');
            $table->unsignedBigInteger('url');
            $table->foreign('url')
                ->references('id')
                ->on('organization_urls');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pdf');
    }
}
