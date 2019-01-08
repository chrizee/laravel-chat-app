<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post("login", "UserController@login")->name("login");
Route::post("register", "UserController@register")->name("register");

Route::group(['middleware' => "auth:api"], function() {

    Route::get("users", "UserController@getUsers")->name("get-users");
    Route::get("logout", "UserController@logout")->name("logout");
    Route::post("addfriend", "FriendsController@store")->name("add-friend");

});
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
