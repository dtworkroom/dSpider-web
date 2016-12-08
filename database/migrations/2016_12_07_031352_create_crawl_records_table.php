<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrawlRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crawl_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('appKey_id')->unsigned();
            $table->integer('spider_id')->unsigned();
            $table->text("config")->nullable();
            $table->tinyInteger("state")->default(-1);
            $table->tinyInteger("platform");
            $table->mediumText("msg")->nullable();
            $table->text("extra")->nullable();
            $table->timestamps();

            $table->foreign("appKey_id")->references('id')->on('app_keys')->onDelete('cascade');
            $table->foreign("spider_id")->references('id')->on('spiders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crawl_records');
    }
}
