<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->mediumText('description');
            $table->mediumText('location')->nullable();
            $table->timestamp('start');
            $table->timestamp('end');
            $table->integer('created_user_id')->unsigned();
            $table->foreign('created_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('visibility_id')->unsigned();
            $table->foreign('visibility_id')->references('id')->on('visibility');
            $table->integer('instrument_id')->unsigned()->nullable();
            $table->foreign('instrument_id')->references('id')->on('instruments')->onDelete('cascade');
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
        Schema::dropIfExists('events');
    }
}
