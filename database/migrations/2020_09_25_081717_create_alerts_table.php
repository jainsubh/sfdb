<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('alerts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ref_id')->unique();
            $table->string('title')->nullable();
            $table->text('summary')->nullable();
            $table->tinyInteger('positive')->default(0);
            $table->tinyInteger('neutral')->default(0);
            $table->tinyInteger('negative')->default(0);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
            $table->unsignedBigInteger('event_id')->nullable();
                $table->foreign('event_id')
                    ->references('id')
                    ->on('events');
            $table->unsignedBigInteger('sector_id');
            $table->foreign('sector_id')
                ->references('id')
                ->on('sectors');
            $table->tinyInteger('archive')->default(0)->comment('0 for not archived , 1 for archived');	
            $table->timestamp('due_date')->useCurrent();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('alert_links', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('url')->charset('utf8')->collate('utf8_bin');
            $table->unsignedBigInteger('alert_id');
            $table->foreign('alert_id')
                ->references('id')
                ->on('alerts');
        });

        Schema::create('alert_gallery', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('images')->collate('utf8_bin');
            $table->unsignedBigInteger('alert_id');
            $table->foreign('alert_id')
                ->references('id')
                ->on('alerts');
        });

        Schema::create('alert_keywords', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('keyword')->collate('utf8_bin');
            $table->unsignedBigInteger('alert_id');
            $table->foreign('alert_id')
                ->references('id')
                ->on('alerts');
            $table->unsignedBigInteger('keyword_id')->nullable();
            $table->foreign('keyword_id')
                ->references('id')
                ->on('alerts');
        });

        Schema::create('alert_comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('comments')->collate('utf8_bin')->nullable();
            $table->unsignedBigInteger('alert_id');
            $table->foreign('alert_id')
                ->references('id')
                ->on('alerts');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('alert_countries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('country_id');
            $table->foreign('country_id')
                ->references('id')
                ->on('countries');
            $table->unsignedBigInteger('alert_id');
            $table->foreign('alert_id')
                ->references('id')
                ->on('alerts');
        });

        Schema::create('alert_tweets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tweets')->collate('utf8_bin')->nullable();
            $table->unsignedBigInteger('alert_id');
            $table->foreign('alert_id')
                ->references('id')
                ->on('alerts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('alerts');
        Schema::dropIfExists('alert_links');
        Schema::dropIfExists('alert_gallery');
        Schema::dropIfExists('alert_keywords');
        Schema::dropIfExists('alert_comments');
        Schema::dropIfExists('alert_countries');
        Schema::dropIfExists('alert_tweets');
        Schema::enableForeignKeyConstraints();
    }
}
