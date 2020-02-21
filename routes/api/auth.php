<?php
Route::namespace('Auth')->prefix('auth')->group(function () {
    Route::post('/forgot', 'ForgotPasswordController@post');
    Route::post('/reset', 'ResetPasswordController@post')->name('password.reset');
    Route::get('/verify', 'VerificationController@verify')->name('verification.verify');
    Route::post('/resend', 'VerificationController@resend');
    Route::post('/refresh', 'AuthController@refresh');
    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('/me', 'AuthController@me');
        Route::post('/sign-out', 'AuthController@signOut');
    });
    Route::group(['middleware' => 'verified'], function () {
        Route::post('/sign-in', 'AuthController@signIn')->name('login');
    });
});
