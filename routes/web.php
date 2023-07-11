<?php

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
Route::get('/','MainController@main');
Route::get('/index','MainController@index');
Route::get('/play/{id}','MainController@play');
Route::get('/search','MainController@search');
Route::post('/message','MainController@message');
Route::post('/comment','MainController@comment');
Route::get('/like','MainController@like');
Route::get('/add','MainController@add');
Route::get('/remove/movie','MainController@remove_movie');
Route::get('/mymovie','MainController@myMovie');
Route::get('/lang/{lang}','MainController@language');
Route::get('/ranking','MainController@ranking');
Route::get('/comment/like','MainController@commentLike');
Route::get('/comment/dislike','MainController@commentLike');

// Button click trigger
Route::get('/trending','AjaxController@trending');
Route::get('/popular','AjaxController@popular');
Route::get('/latest','AjaxController@latest');
Route::get('/commingSoon','AjaxController@commingSoon');

//More click 
Route::get('/popularLink','MoreController@popular');
Route::get('/trendingLink','MoreController@trending');
Route::get('/upcomingLink','MoreController@commingSoon');
Route::get('/latestLink','MoreController@latest');
Route::get('/dramasLink','MoreController@dramas');
Route::get('/dramasLink','MoreController@dramas');

Route::get('/notice',function(){
    return view("notice");
});

// Form route
Auth::routes();
