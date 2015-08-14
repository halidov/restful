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
        Route::resource('menus.categories', 'MenuCategoryController');
        Route::resource('menus.categories.foods', 'CategoryFoodController');
        Route::resource('waiters', 'WaiterController');
        Route::resource('clients', 'ClientController');
        Route::resource('waiters.clients', 'WaiterClientController', ['only'=>['index','store','destroy']]);

    });

    Route::group(['prefix'=>'waiter', 'middleware' => 'check_role:is_waiter' ], function () {
        Route::resource('clients', 'WaiterWaiterClientController', ['only'=>['index']]);
        Route::resource('orders', 'WaiterOrderController', ['only'=>['index', 'update']]);
    });

    Route::group(['prefix'=>'client', 'middleware' => 'check_role:is_client' ], function () {

        Route::resource('categories', 'ClientCategoryController', ['only'=>['index']]);
        Route::resource('categories.foods', 'ClientCategoryFoodController', ['only'=>['index']]);
        Route::resource('orders', 'OrderController', ['except'=>['delete']]);

    });
});