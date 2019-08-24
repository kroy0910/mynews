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

Route::get('/', function () {
    return view('welcome');
});

//postはformのデフォルト(urlに表示されるデータではないから）
Route::group(['prefix' => 'admin'], function() {
    Route::get('news/create', 'Admin\NewsController@add')->middleware('auth');
    Route::post('news/create', 'Admin\NewsController@create')->middleware('auth');
    Route::get('news', 'Admin\NewsController@index')->middleware('auth'); 
    Route::get("news/edit","Admin\NewsController@edit")->middleware('auth');
    Route::post("news/edit","Admin\NewsController@update")->middleware("auth");
    Route::get("news/delete","Admin\NewsController@delete")->middleware("auth");
});

Route::group(["prefix"=>"admin/profile"],function(){
    //createとeditの違いが明確でないが
    //create→新規作成edit→編集とするとそもそも編集が不要なのでは
    //create→新規作成（更新）とした方がcreateのみでスッキリする
    //profileControllerに@updataと@editを作成したが、使わないで実行してみる
    //viewにedit画面とindex画面を作成したが、使わないで実行してみる
    Route::get("create","Admin\ProfileController@add")->middleware('auth');
    Route::post("create","Admin\ProfileController@create")->middleware('auth');
    Route::get("edit","Admin\ProfileController@edit")->middleware('auth');
    Route::post("edit","Admin\ProfileController@update")->middleware('auth');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/',"NewsController@index");
Route::get('/profile',"ProfileController@index");
