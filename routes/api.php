<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {
    Route::get('test', function (Request $request) {
        return response()->json(['data' => 'I got tested']);
    });

    Route::prefix('auth')->group(function () {
        Route::post('register', ['as' => 'auth.register', 'uses' => 'Api\Auth\RegisterController@register']);
        Route::post('login', ['as' => 'auth.login', 'uses' => 'Api\Auth\LoginController@login']);
    });

    Route::prefix('course')->group(function () {
        Route::get('', ['as' => 'course.index', 'uses' => 'Api\CourseController@index']);
        Route::get('populate', ['as' => 'course.populate', 'uses' => 'Api\CourseController@populate']);
        Route::post('register', ['as' => 'course.register', 'uses' => 'Api\CourseController@register']);
    });
});
