<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('status');
            $table->integer('client_id')->unsigned()->index();
            $table->foreign('client_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('waiter_id')->unsigned()->nullable()->index();
            $table->foreign('waiter_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['client_id', 'status']);
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
        Schema::drop('orders');
    }
}
