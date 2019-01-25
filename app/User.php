<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use App\Chat;
use App\Friends;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //this relationship is just for creating a new friend on a given user instance
    public function friend() {
        return $this->hasMany(Friends::class);
    }
    public function friend1() {
        return $this->belongsToMany(User::class, 'friends', "user_id", "friend_id");
    }

    public function friend2() {
        return $this->belongsToMany(User::class, 'friends', "friend_id" , "user_id");
    }

    public function friends() {
        return $this->friend1->merge($this->friend2);
    }

    public function chat() {
        return $this->hasMany(Chat::class);
    }
}
