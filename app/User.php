<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
class User extends Authenticatable
{
    use Notifiable,HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'gender'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function rooms(){
        return $this->hasMany('App\roomsowners','user','id');
    }
     public function plan(){
        return $this->hasOne('App\plans','id','role');
    }
    public function subscription(){
        return $this->hasOne('App\subscriptions','user','id');
    }

    public function story(){
        return $this->hasMany(story::class,'user','id');
    }

    public function AauthAcessToken(){
    return $this->hasMany('\App\OauthAccessToken');
}

}
