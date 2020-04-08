<?php

Route::get('/', ['as'=> 'api.home.index', 'uses'=> 'ExampleController@index']);

//Route::group(['prefix'=> 'auth'], function ($api)
//{
//    Route::post('/login', [ 'as' => 'api.auth.login', 'uses' => 'Auth\LoginController@login']);
//    Route::get('/register', ['as' => 'api.auth.register', 'uses' =>  'Auth\LoginController@register']);
//    Route::get('/refresh', ['as' => 'api.auth.refresh', 'uses' => 'Auth\LoginController@refresh']);
//});
//
//Route::group(['middleware'=> 'api.auth.jwt'], function ($api) {
//    Route::get('me', [ 'as' => 'api.auth.user', 'uses' => 'Auth\AuthController@getUser']);
//    Route::patch('/auth/user', [ 'as' => 'api.auth.update', 'uses' => 'Auth\AuthController@patch']);
//    Route::put('auth/password', [ 'as' => 'api.password.update', 'uses' => 'Auth\PasswordController@edit']);
//    Route::get('/auth/invalidate', [ 'as' => 'api.auth.invalidate', 'uses' => 'Auth\LoginController@deleteInvalidate']);
//});