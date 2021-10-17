<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class rooms extends Model
{
     public function get_room_users(){
        return $this->hasMany('App\room_users','room_id','id');
    }
     public function get_available_users(){
        return $this->hasMany('App\available_users','room_id','id');
    }
    public function messages(){
        return $this->hasMany('App\messages','room_id','id');
    }
    protected $hidden = [
        'password'
    ];
}
