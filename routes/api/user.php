<?php

Route::prefix('users')->group(function () {
    Route::group(['middleware' => 'auth'], function () {
        Route::post('/', 'UserController@post');
        Route::get('/', 'UserController@get');
        Route::put('/{uuid}', 'UserController@put');
    });
});
