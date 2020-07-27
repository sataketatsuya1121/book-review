<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => ['api']], function () {
    Route::post('/reviewCount', 'Api\BookReviewController@createReviewCountApi')->name('reviewCountApi');
    Route::post('/starCount', 'Api\BookReviewController@createStarCountApi')->name('starCountApi');
});

Route::group(['middleware' => ['auth:api']], function () {
    Route::post('/notification', 'Api\BookReviewController@createNotificationApi')->name('notificationApi');
});

