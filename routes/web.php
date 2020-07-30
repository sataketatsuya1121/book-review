<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Auth::routes();

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');

Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/login/github', 'Auth\LoginController@redirectToProvider')->name('github');
Route::get('/login/github/callback', 'Auth\LoginController@handleProviderCallback')->name('githubCall');
Route::get('/login/google', 'Auth\LoginController@getGoogleAuth')->name('google');
Route::get('/login/callback/google', 'Auth\LoginController@authGoogleCallback');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/review', 'BookReviewController@index')->name('review');
    Route::post('/review', 'BookReviewController@index')->name('review');
    Route::get('/review/{userId}/user', 'BookReviewController@showUserPage')->name('user');
    Route::get('/review/mypage', 'BookReviewController@showMypage')->name('mypage');
    Route::put('/review/{reviewId}', 'BookReviewController@updateBookReview')->name('updateReview');
    Route::delete('/review/{reviewId}', 'BookReviewController@destroyBookReview')->name('destroyReview');
    Route::post('/review/create', 'BookReviewController@storeBookReview')->name('createReview');
    Route::get('/review/{isbn}/detail', 'BookReviewController@showDetailPage')->name('detail');

    Route::post('/review/{reviewId}/like', 'LikeController@like')->name('like');
    Route::post('/review/{reviewId}/unLike', 'LikeController@unLike')->name('unLike');

    Route::get('/review/my_info', 'UserController@showMyInfoPage')->name('myInfo');
    Route::post('/review/user/create', 'UserController@createMyInfo')->name('createMyInfo');
    Route::put('/review/{userId}/update', 'UserController@updateUser')->name('updateUser');
    Route::delete('/review/user/destroy', 'UserController@destroyUser')->name('destroyUser');

    Route::post('/review/{isbn}/stock', 'StockController@storeStock')->name('stock');
    Route::delete('/review/{isbn}/unstock', 'StockController@destroyStock')->name('unstock');
    Route::delete('/review/{isbn}/unstock_mypage', 'StockController@destroyMypageStock')->name('unstockMypage');

    Route::post('/review/{isbn}/recommend', 'UserController@storeRecommend')->name('recommend');
    Route::delete('/review/{isbn}/unRecommend', 'UserController@destroyRecommend')->name('unRecommend');

    Route::post('/review/comment', 'CommentController@postComment')->name('postComment');
    Route::put('/review/{commentId}/comment', 'CommentController@editComment')->name('editComment');
    Route::delete('/review/{commentId}/comment', 'CommentController@destroyComment')->name('deleteComment');
    Route::get('/review/user_list', 'UserController@showUserList')->name('userList');

    Route::post('/review/{favoriteId}/favorite', 'FavoriteController@favorite')->name('favorite');
    Route::post('/review/{favoriteId}/unFavorite', 'FavoriteController@unFavorite')->name('unFavorite');

    Route::get('/review/ranking', 'BookReviewController@showRankingPage')->name('ranking');
    Route::get('/review/new_book', 'BookReviewController@showNewBookPage')->name('newBook');
    Route::get('/review/stock_list', 'BookReviewController@showStockListPage')->name('stockList');

    Route::get('/mark/{notificationId}/{isbn}/review', 'NotificationController@markAsReadReview')->name('markReview');
    Route::get('/mark/{notificationId}/{isbn}/user', 'NotificationController@markAsReadUser')->name('markUser');
    Route::post('/markAsRead', 'NotificationController@markAsReadAllNotifications')->name('markAsReadApi');

    Route::get('/review/{booksGenreId}/results', 'BookReviewController@showResult')->name('showResult');
});
