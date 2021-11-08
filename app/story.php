<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class story extends Model
{
    protected $table = 'story';
    protected $fillable = [
        "file",
        "user",
        "filetype",
    ];


    public function users(){
        return $this->belongsToMany(User::class, "story_users");
    }
}
