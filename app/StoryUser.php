<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoryUser extends Model
{
    protected $table = "story_users";
    protected $fillable = [
        "story_id",
        "user_id",
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function story()
    {
        return $this->belongsTo(story::class);
    }
}
