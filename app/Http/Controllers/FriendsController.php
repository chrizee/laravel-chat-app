<?php

namespace App\Http\Controllers;

use App\Friends;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FriendsController extends Controller
{

    /**
     * get the friends of the currently authenticated user
     *
     * @return \Illuminate\Http\Response
     */
    public function getFriends()
    {
        $user = auth()->user();
        $friends = $user->friends();
        return response()->json(['success' => true, 'friends' => $friends]);
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
            "friend_id" => "required|exists:users,id"
        ]);

        if($validator->fails()) {
            return response()->json(['error' => $validator->errors(), "success" => false], 401);
        }
        $user = auth()->user();
        //prevent duplicate friends, check if a friendship exist between the two users before creating a new one
        $check = Friends::where([
                ["user_id", '=', $user->id],
                ["friend_id", '=', $request->input("friend_id")]
            ]
        )->orWhere([
                ["friend_id", '=', $user->id],
                ["user_id", '=', $request->input("friend_id")]
            ]
        )->get();
        if(count($check) == 0) {       
            $user->friend()->create([
                "friend_id" => $request->input('friend_id')
            ]);
        }
        return response()->json(['success' => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Friends  $friends
     * @return \Illuminate\Http\Response
     */
    public function show(Friends $friends)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Friends  $friends
     * @return \Illuminate\Http\Response
     */
    public function edit(Friends $friends)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Friends  $friends
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Friends $friends)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Friends  $friends
     * @return \Illuminate\Http\Response
     */
    public function destroy(Friends $friends)
    {
        //
    }
}
