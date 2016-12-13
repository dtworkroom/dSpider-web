<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('spiders', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name",50);
            $table->integer("user_id")->unsigned()->default(0);
            $table->text("content")->nullable();
            $table->string("description");
            $table->text("readme")->nullable();
            $table->smallInteger("support")->default(7);
            $table->integer("star")->default(0);
            $table->smallInteger("chargeType")->default(0);
            $table->integer("freeLimits")->default(100);
            $table->float("price")->default(0);
            $table->text("defaultConfig")->nullable();
            $table->integer("callCount")->default(0);
            $table->boolean("public")->default(false);
            $table->Integer("access")->default(3);
            $table->text("startUrl");
            $table->tinyInteger("ua")->default(1);
            $table->timestamps();
            $table->foreign("user_id")->references('id')->on('users')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('spiders');
    }
}
