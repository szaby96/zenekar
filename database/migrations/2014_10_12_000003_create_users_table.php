<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->integer('right_id')->unsigned()->default('1');
            $table->foreign('right_id')->references('id')->on('rights');
            $table->integer('instrument_id')->unsigned()->nullable();
            $table->foreign('instrument_id')->references('id')->on('instruments')->onDelete('set null');
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->string('password');
            $table->string('profile_picture')->default('default.jpg');
            $table->boolean('public_events_notifications')->default('0');
            $table->boolean('band_events_notifications')->default('0');
            $table->boolean('group_events_notifications')->default('0');
            $table->boolean('public_posts_notifications')->default('0');
            $table->boolean('band_posts_notifications')->default('0');
            $table->boolean('group_posts_notifications')->default('0');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
