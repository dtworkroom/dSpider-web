<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScriptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scripts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("spider_id")->unsigned()->default(0);
            $table->integer("callCount")->unsigned()->default(0);
            $table->boolean("online")->default(false);
            $table->string("min_sdk",15)->default("1.0.0");
            $table->text("content")->nullable();
            $table->tinyInteger("priority")->default(0);
            $table->timestamps();
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
        Schema::dropIfExists('scripts');
    }
}
