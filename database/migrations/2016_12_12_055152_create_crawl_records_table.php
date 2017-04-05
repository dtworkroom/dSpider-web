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
            $table->integer('script_id')->unsigned()->default(0);
            $table->text("config")->nullable();
            $table->tinyInteger("state")->default(-1);
            $table->mediumText("msg")->nullable();
            $table->string("app_version",20)->nullable();
            $table->string("sdk_version",20)->nullable();
            $table->tinyInteger("os_type");
            $table->integer("device_id")->unsigned();
            $table->text("ip",15)->nullable();
            $table->timestamps();

            $table->foreign("appKey_id")->references('id')->on('app_keys')->onDelete('cascade');
            $table->foreign("spider_id")->references('id')->on('spiders')->onDelete('cascade');
            $table->foreign("device_id")->references('id')->on('devices')->onDelete('cascade');
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
