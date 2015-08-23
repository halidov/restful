<?php

Route::group(['prefix'=>'api', 'middleware' => 'auth.basic'], function () {

    Route::resource('notifications', 'NotificationController', ['only'=>['index', 'store']]);

    Route::group(['prefix'=>'admin', 'middleware' => 'check_role:admin' ], function () {

        Route::resource('menus', 'MenuController');
        Route::resource('menus.categories', 'MenuCategoryController');
        Route::resource('menus.categories.foods', 'CategoryFoodController');
        Route::resource('waiters', 'WaiterController');
        Route::resource('clients', 'ClientController');
        Route::resource('waiters.clients', 'WaiterClientController', ['only'=>['index','store','destroy']]);

    });

    Route::group(['prefix'=>'waiter', 'middleware' => 'check_role:is_waiter' ], function () {
        Route::resource('clients', 'WaiterWaiterClientController', ['only'=>['index', 'update']]);
        Route::resource('orders', 'WaiterOrderController', ['only'=>['index', 'update']]);
        Route::resource('bills', 'WaiterBillsController', ['only'=>['index']]);
    });

    Route::group(['prefix'=>'client', 'middleware' => 'check_role:is_client' ], function () {

        Route::resource('categories', 'ClientCategoryController', ['only'=>['index']]);
        Route::resource('categories.foods', 'ClientCategoryFoodController', ['only'=>['index']]);
        Route::resource('orders', 'OrderController', ['only'=>['index', 'store']]);

    });
});