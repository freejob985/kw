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

Route::get('/','userController@index');


Route::post('register','userController@register')->name('register');
Route::post('verify','userController@verify')->name('verify');
Route::post('register/guest','userController@registerGuest')->name('register.guest');
Route::post('login','userController@login')->name('login');
Route::get('test','userController@test')->name('d');
Route::post('initialRoom','userController@initialRoom')->name('initialRooms');
Route::post('addMessage','userController@addMessage')->name('addMessage');
Route::post('getchat','userController@getchat')->name('getchat');
Route::post('sendPrivateMessage','userController@sendPrivateMessage')->name('sendPrivateMessage');
Route::get('getRooms','userController@getRooms')->name('getRooms');
Route::get('getRoom/{id}/{previous}','userController@getRoom')->name('getRoom');
Route::get('logout/','userController@logout')->name('logout');
Route::get('getChatByid/{id}','userController@getChatByid')->name('getChatByid');
Route::get('getPrivateNotifications','userController@getPrivateNotifications')->name('getPrivateNotifications');
Route::post('uploadfile','userController@uploadfile')->name('uploadfile');
Route::post('private/uploadfile','userController@private_uploadfile')->name('private_uploadfile');
Route::post('uploadvoice','userController@uploadvoice')->name('uploadvoice');
Route::post('updateProfile','userController@updateProfile')->name('updateProfile');
Route::post('updateProfileImage','userController@updateProfileImage')->name('updateProfileImage');
Route::post('removeEnroll','userController@removeEnroll')->name('removeEnroll');
Route::get('deleteProfileImage','userController@deleteProfileImage')->name('deleteProfileImage');
Route::get('payment/{plan}','userController@payment')->name('payment');
Route::get('verifyPayment','userController@verifyPayment')->name('verifyPayment');
Route::get('allusers','userController@allusers')->name('allusers');
Route::get('usersinroom/{room}','userController@usersinroom')->name('usersinroom');
Route::post('accessRoombypass','userController@accessRoombypass')->name('accessRoombypass');
Route::post('addNewRoom','userController@addNewRoom')->name('addNewRoom');
Route::post('banUsers','userController@banUsers')->name('banUsers');
Route::post('new','userController@newconnection')->name('newconnection');
Route::get('bad','userController@badwords')->name('bad');
Route::get('get_user_Rooms','userController@get_user_Rooms')->name('get_user_Rooms');
Route::post('remove_my_room','userController@remove_my_room')->name('remove_my_room');
Route::get('hash',function (){
    return Hash::make('admin');
});
Route::get('broadme',function (){
    broadcast(new \App\Events\Test('Hi'));
});
