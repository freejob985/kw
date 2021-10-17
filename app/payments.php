<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class payments extends Model
{
    public function userObj(){
        return $this->hasOne('\App\User','id','user_id');
    }
}
