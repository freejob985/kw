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

$prefix = 'api';
Route::post('register','userControllerApi@register')->name($prefix.'.'.'register');//done
Route::post('register/guest','userControllerApi@registerGuest')->name($prefix.'.'.'register.guest');//done
Route::post('login','userControllerApi@login')->name($prefix.'.'.'login');//done
Route::get('verifyPayment','userControllerApi@verifyPayment')->name($prefix.'.'.'verifyPayment');//done
Route::get('getPlans','userControllerApi@getPlans')->name($prefix.'.'.'getPlans');//done
Route::get('terms','userControllerApi@getTerms')->name($prefix.'.'.'getTerms');//done
Route::get('channels','userControllerApi@getChannels')->name($prefix.'.'.'getChannels');//done
Route::post('forgot_request','userControllerApi@forgot_request')->name($prefix.'.'.'forgot_request');//done
Route::post('forgot_request_set','userControllerApi@forgot_request_set')->name($prefix.'.'.'forgot_request_set');//done
Route::get('banners','userControllerApi@banners')->name($prefix.'.'.'banners');//done
Route::group(['middleware' => 'auth:api'],function () use ($prefix){
Route::post('verify','userControllerApi@verify')->name($prefix.'.'.'verify'); //done
Route::post('initialRoom','userControllerApi@initialRoom')->name($prefix.'.'.'initialRooms');//done
Route::post('addMessage','userControllerApi@addMessage')->name($prefix.'.'.'addMessage');//done
Route::post('getchat','userControllerApi@getchat')->name($prefix.'.'.'getchat');//done
Route::post('sendPrivateMessage','userControllerApi@sendPrivateMessage')->name($prefix.'.'.'sendPrivateMessage');//done
Route::get('getRooms','userControllerApi@getRooms')->name($prefix.'.'.'getRooms');//done
Route::get('getRoom/{id}/{previous}','userControllerApi@getRoom')->name($prefix.'.'.'getRoom');//done
Route::post('logout/','userControllerApi@logout')->name($prefix.'.'.'logout');//done
Route::get('getChatByid/{id}','userControllerApi@getChatByid')->name($prefix.'.'.'getChatByid');//done
Route::get('getPrivateNotifications','userControllerApi@getPrivateNotifications')->name($prefix.'.'.'getPrivateNotifications');//done
Route::post('uploadfile','userControllerApi@uploadfile')->name($prefix.'.'.'uploadfile');//done
Route::post('private_uploadfile','userControllerApi@private_uploadfile')->name($prefix.'.'.'private_uploadfile');//done
Route::post('uploadvoice','userControllerApi@uploadvoice')->name($prefix.'.'.'uploadvoice');//done
Route::post('updateProfile','userControllerApi@updateProfile')->name($prefix.'.'.'updateProfile');//done
Route::post('updateProfileImage','userControllerApi@updateProfileImage')->name($prefix.'.'.'updateProfileImage');//done
Route::post('removeEnroll','userControllerApi@removeEnroll')->name($prefix.'.'.'removeEnroll');//done
Route::get('deleteProfileImage','userControllerApi@deleteProfileImage')->name($prefix.'.'.'deleteProfileImage');//done
Route::get('profile/get','userControllerApi@get_profile')->name($prefix.'.'.'get_profile');//done
Route::get('payment/{plan}','userControllerApi@payment')->name($prefix.'.'.'payment');//done
Route::post('make/payment','userControllerApi@payment_check')->name($prefix.'.'.'payment_check');//done

Route::get('allusers','userControllerApi@allusers')->name($prefix.'.'.'allusers');//done
Route::get('usersinroom/{room}','userControllerApi@usersinroom')->name($prefix.'.'.'usersinroom');//done
Route::post('accessRoombypass','userControllerApi@accessRoombypass')->name($prefix.'.'.'accessRoombypass');//done
Route::post('addNewRoom','userControllerApi@addNewRoom')->name($prefix.'.'.'addNewRoom');//done
Route::post('banUsers','userControllerApi@banUsers')->name($prefix.'.'.'banUsers');//done
Route::post('new','userControllerApi@newconnection')->name($prefix.'.'.'newconnection');//done
Route::get('bad','userControllerApi@badwords')->name($prefix.'.'.'bad');//done
});

/*
|--------------------------------------------------------------------------
| er web
|--------------------------------------------------------------------------
*/
Route::post('add_story','userControllerApi@add_story')->name($prefix.'.'.'add_story');//done
Route::get('getstory','userControllerApi@getstory')->name($prefix.'.'.'getstory');//done
Route::get('getstory/user/{id}','userControllerApi@getstory_user')->name($prefix.'.'.'getstory.user');//done
Route::get('getstory/profile','userControllerApi@getstory_profile')->name($prefix.'.'.'getstory.profile');//done
Route::get('getstory/delete/{id}','userControllerApi@getstory_delete')->name($prefix.'.'.'getstory.delete');//done
Route::get('existing/story/{id}','userControllerApi@Existing_story')->name($prefix.'.'.'existing.story');//done

Route::post('abbreviation/story','userControllerApi@abbreviation')->name($prefix.'.'.'abbreviation.story');//done
Route::get('abbreviation/get','userControllerApi@abbreviation_get')->name($prefix.'.'.'abbreviation.all');//done


Route::get('ban/{id}','userControllerApi@ban')->name($prefix.'.'.'ban.user');//done

Route::get('get/ban','userControllerApi@get_ban')->name($prefix.'.'.'get.ban');//done

Route::get('unban/delete/{id}','userControllerApi@unban')->name($prefix.'.'.'unban.delete');//done

Route::get('getRoom/uesr/{id}','userControllerApi@getRoom_uesr')->name($prefix.'.'.'getRoom.uesr');//done
/*
|--------------------------------------------------------------------------
| er web
|--------------------------------------------------------------------------
*/





