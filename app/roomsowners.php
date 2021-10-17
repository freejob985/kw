<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class roomsowners extends Model
{
      public function room(){
        return $this->hasOne('App\rooms','id','room');
    }
}
