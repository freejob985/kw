<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class privateChat extends Model
{
    protected $fillable = [
        'hide_chat'
    ];

    public function getPrivateNotifications(){
       return $this->hasOne('\App\privateNotifications','chat','id');
    }
     public function privateChatMessages(){
        return $this->hasMany('\App\privateChatMessage','chat','id');
    }
}
