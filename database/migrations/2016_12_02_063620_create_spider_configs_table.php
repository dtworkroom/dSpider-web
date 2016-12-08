<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpiderConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spider_configs', function (Blueprint $table) {
            $table->increments('id');
            $table->text("content")->nullable();
            $table->integer("spider_id")->unsigned();
            $table->integer("appKey_id")->unsigned();
            $table->integer("callCount")->default(0);
            $table->boolean("online")->default(true);
            $table->timestamps();
            $table->foreign("appKey_id")->references('id')->on('app_keys')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('spider_configs');
    }
}
