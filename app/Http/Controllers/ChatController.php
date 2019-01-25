<?php

namespace App\Http\Controllers;

use App\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "friend_id" => "required|exists:users,id",
            //"skip" => "required|integer"
        ]);
        if($validator->fails()) {
            return response()->json(["success" => false, "message" => $validator->errors()] );
        }
        $userId = auth()->user()->id;
        $friendId = $request->input("friend_id");
        $chatQ = Chat::latest()->where(function ($query) use ($friendId, $userId) {
            $query->where("user_id", '=', $userId)->where("friend_id", "=", $friendId);
        })->orWhere(function ($query) use ($friendId, $userId) {
            $query->where("user_id", '=', $friendId)->where("friend_id", "=", $userId);
        });
        $chat = $chatQ->orderBy('id', "DESC")->paginate(2);
        //$chat = $chatQ->skip($request->input('skip'))->take(7)->get();
        //$chatQ->update(['friend_status' => '1']);
        return response()->json(["success" => true, "chats" => $chat] );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "chat" => "required|string",
            "friend-id" => "required|exists:users,id"
        ]);
        if($validator->fails()) {
            return response()->json(["success" => false, "message" => $validator->errors()] );
        }
        $user = auth()->user();
        $chat = $request->input('chat');
        if($request->hasFile("photo")) {
            
            $filePath = storage_path() . "/app/public/Chat/";
            if (!\File::isDirectory($filePath))
            {
                \File::makeDirectory($filePath);
            }
            $filename = "chat_".uniqid().".".$request->file("photo")->getClientOriginalExtension();
            $request->file("photo")->storeAs("public/Chat", $filename);
            
            //$chat = "@#image@#-".str_replace("\\", "/", $filePath).$filename;
            $chat = "@#image@#-"."storage/Chat/".$filename;
        }
        $chat = $user->chat()->create([
            'chat' => $chat,
            'friend_id' => $request->input("friend-id")
        ]);
        //broadcast(new BroadcastChat($chat));
        return response()->json(["success" => true, "chat" => $chat] );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function show(Chat $chat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function edit(Chat $chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Chat $chat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chat $chat)
    {
        //
    }
}
