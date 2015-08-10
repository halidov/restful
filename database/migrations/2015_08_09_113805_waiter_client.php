<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WaiterClient extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('waiter_client', function (Blueprint $table) {
            $table->integer('waiter_id')->unsigned()->index();
            $table->foreign('waiter_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('client_id')->unsigned()->index();
            $table->foreign('client_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('menus', function ($table) {
            $table->softDeletes();
        });

        Schema::table('categories', function ($table) {
            $table->softDeletes();
        });

        Schema::table('foods', function ($table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('waiter_client');

        Schema::table('menus', function ($table) {
            $table->dropColumn('deleted_at');
        });

        Schema::table('categories', function ($table) {
            $table->dropColumn('deleted_at');
        });

        Schema::table('foods', function ($table) {
            $table->dropColumn('deleted_at');
        });

    }
}
