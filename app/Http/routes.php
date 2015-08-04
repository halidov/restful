<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['prefix'=>'api', 'middleware' => 'auth.basic'], function () {

    Route::group(['prefix'=>'admin', 'middleware' => 'check_role:admin' ], function () {

        Route::resource('menus', 'MenuController');
        Route::resource('waiters', 'WaiterController');
        Route::resource('clients', 'ClientController');

    });

    Route::group(['prefix'=>'waiter', 'middleware' => 'check_role:is_waiter' ], function () {

        Route::get('/', function() {
        	return ['ok'];
        });

    });

    Route::group(['prefix'=>'client', 'middleware' => 'check_role:is_client' ], function () {

        Route::get('/', function() {
        	return ['ok'];
        });

    });
});