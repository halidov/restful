<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('name');
            $table->string('password', 60);
            $table->boolean('is_client');
            $table->boolean('is_waiter');
            $table->integer('admin_id')->nullable()->unsigned();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('admin_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
