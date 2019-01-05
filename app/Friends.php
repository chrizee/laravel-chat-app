<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friends extends Model
{
   	public function user()
    {
        return $this->user1->merge($this->user2);
    }

    public function user1()
    {
        return $this->belongsTo("App\User","user_id");
    }

    public function user2()
    {
        return $this->belongsTo("App\User","friend_id");
    }
}
