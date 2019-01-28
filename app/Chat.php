<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Events\BroadcastChat;

class Chat extends Model
{

	protected $dispatchesEvents = [
        "created" => BroadcastChat::class
    ];
   protected $guarded = [

   ];

   public function user() 
   {
   	return $this->belongsTo(App\User::class);
   } 
}
