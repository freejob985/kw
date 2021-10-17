<?php

use Illuminate\Support\Facades\Broadcast;
use App\rooms;
use App\room_users;
use App\rooms_ban;
use App\available_users;
use \Carbon\Carbon;
/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
Broadcast::channel('room.{id}', function ($user,$id) {
        $user->image = url('images/profiles/') .'/'. $user->image;
        $room = rooms::find($id);
        $room_ban = rooms_ban::where('user',$user->id)->whereDate('ban_end_at','>=',Carbon::now())->first();
        if($room_ban){
            return false;
        }
        $enroll = room_users::where('room_id',$id)->where('user_id',$user->id)->first();  
    if($room->type == 'secure'){
          if($enroll){
              $checks = available_users::where('room_id',$id)->where('user_id',$user->id)->first();  
              if(!$checks){
                      $new_room_user = new available_users();
               $new_room_user->room_id = $id;
               $new_room_user->user_id = $user->id;
               $new_room_user->save();
              }
               return $user;
          }else{
               return false;
          }
    }else{
               $checks = available_users::where('room_id',$id)->where('user_id',$user->id)->first();  
              if(!$checks){
                      $new_room_user = new available_users();
               $new_room_user->room_id = $id;
               $new_room_user->user_id = $user->id;
               $new_room_user->save();
              }
               return $user;
    }
 
  
});
Broadcast::channel('chat-private.{id}', function ($user, $id) {
    return $user;
});
Broadcast::channel('active', function ($user) {
     $user->image = url('images/profiles/') .'/'. $user->image;
    return $user;
});

Broadcast::channel('notifications-private.{id}', function ($user, $id) {
    return $user;
});
Broadcast::channel('gaber.{id}', function ($user, $id) {
    return $user;
});
Broadcast::channel('ban.{id}', function ($user, $id) {
    return $user;
});


