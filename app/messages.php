<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class messages extends Model
{
    public function room(){
        return $this->hasOne('\App\rooms','id','room_id');
    }
    public function user(){
        return $this->hasOne('\App\User','id','user_id');
    }
}
