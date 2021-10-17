<?php

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
Route::group(['prefix' => 'admin'],function (){
     Route::get('/login' , 'adminController@login')->name('admin.login');
            Route::post('/login' , 'adminController@loginPost')->name('admin.login.post');
});
Route::group(['prefix' => 'admin','middleware' => 'admin'],function (){
    Route::get('/','adminController@users')->name('home');
    Route::get('/users','adminController@users')->name('users');
    Route::get('/monitors','adminController@monitors')->name('admin.monitors');
    Route::get('/chat/history','adminController@get_chat_history')->name('admin.get_chat_history');
    Route::get('/users/add','adminController@usersCreate')->name('users.create');
    Route::post('/users/add','adminController@usersInsert')->name('users.insert');
    Route::get('/users/edit/{id}','adminController@usersEdit')->name('users.edit');
    Route::post('/users/edit/{id}','adminController@usersUpdate')->name('users.update');
    Route::get('/plans','adminController@plans')->name('plans');
    Route::get('/plans/add','adminController@addplans')->name('plans.add');
    Route::post('/plans/add','adminController@insertplans')->name('plans.insert');
    Route::get('/plans/edit/{id}','adminController@editplans')->name('plan.edit');
    Route::post('/plans/edit/{id}','adminController@updateplans')->name('plan.update');
    Route::get('/bad/words','adminController@bad')->name('bad.words');
    Route::get('/bad/words/create','adminController@createbad')->name('bad.create');
    Route::post('/bad/words/create','adminController@insertbad')->name('bad.insert');
    Route::get('/bad/words/edit/{id}','adminController@editbad')->name('bad.edit');
    Route::post('/bad/words/edit/{id}','adminController@updatebad')->name('bad.update');
    Route::get('/logout' , 'adminController@logout')->name('admin.logout');
    Route::get('/sliders' , 'adminController@sliders')->name('admin.sliders');
    Route::post('/sliders/remove/{id}','adminController@remove_image_slider')->name('sliders_image_remove');
    Route::post('/sliders/upload','adminController@upload_slider')->name('sliders_upload');
    Route::get('/banners' , 'adminController@banners')->name('admin.banners');
    Route::post('/banners/upload' , 'adminController@banners_image')->name('banner_upload');
    Route::get('/monitors/add','adminController@monitorsCreate')->name('monitors.create');
    Route::post('/monitors/add','adminController@monitorsInsert')->name('monitors.insert');
    Route::get('/monitors/edit/{id}','adminController@monitorsEdit')->name('monitors.edit');
    Route::post('/monitors/edit/{id}','adminController@monitorsUpdate')->name('monitors.update');
    Route::get('/music/channels','adminController@getMusicChannels')->name('admin.getMusicChannels');
    Route::get('/music/channels/add','adminController@getaddMusicChannels')->name('admin.getaddMusicChannels');
    Route::post('/music/channels/add','adminController@postaddMusicChannels')->name('admin.postaddMusicChannels');
    Route::get('/music/channels/edit/{id}','adminController@getupdateMusicChannels')->name('admin.getupdateMusicChannels');
    Route::post('/music/channels/edit/{id}','adminController@postupdateMusicChannels')->name('admin.postupdateMusicChannels');
    Route::get('/terms','adminController@terms')->name('admin.terms');
    Route::post('/terms','adminController@terms_update')->name('admin.terms_update');
           
});