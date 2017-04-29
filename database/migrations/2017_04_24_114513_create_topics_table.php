<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->increments('tid');
            $table->string('title')->index();
            $table->integer('uid');
            $table->string('tags');
            $table->tinyInteger('islook');
            $table->tinyInteger('isshow');
            $table->tinyInteger('istop');
            $table->tinyInteger('isgood');
            $table->integer('click');
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
        Schema::drop('topics');
    }
}
