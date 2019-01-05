<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("user_id")->unsigned();
            $table->integer("friend_id")->unsigned();
            $table->text("chat");
            $table->enum("type", [0,1])->default(0);        //0 message, 1 image
            $table->enum("user_status", [0,1,2])->default(0);      //sent(save to db),delivered(shown to friend), seen(read by friend)
            $table->enum("friend_status",[0,1,2])->default(0);    //0(save to db),received(shown), seen(read)

            $table->foreign("friend_id")->references('id')->on("users");
            $table->foreign("user_id")->references('id')->on("users");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chats');
    }
}
