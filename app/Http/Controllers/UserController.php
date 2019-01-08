<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\User as UserResource;

class UserController extends Controller
{
    use AuthenticatesUsers {
        logout as upLogout;
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => "required|email",
            'password' => "required"
            ]);

        if($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors(), "success" => false], 401);
        }

        $response = ['error' => "unauthorized", "success" => false];
        $status = 401;
        if(Auth::attempt($request->only(['email', 'password']))) {
            $status = 200;
            Auth::user()->createToken('login')->accessToken;
            $response = [
                'user' => new UserResource(auth()->user()),
                'token' => auth()->user()->createToken('login')->accessToken,
                "success" => true
            ];
        }
        return response()->json($response, $status);
    }

    public function register(Request $request)
    {
        $validator  = Validator::make($request->all(), [
            'name' => "required|string|max:191",
            'email' => "required|email|unique:users",
            'password' => "required|min:6|confirmed",
        ]);

        if($validator->fails()) {
            return response()->json(['error' => $validator->errors(), "success" => false], 401);
        }

        if($request->has('picture')) {
            Image::make();
        }
        $data = $request->only(['name', 'email']);
        $data['password'] = bcrypt($request->input('password'));
        $user = User::create($data);
        return response()->json([
            "success" => true,
            'user' => new UserResource($user),
            'token' => $user->createToken("login")->accessToken
        ]);
    }

    public function logout(Request $request)
    {
        $this->upLogout($request);
        $user = auth()->user();
        //revoke all token for the current user
        foreach ($user->tokens as $token) {
            $token->revoke();
        }
        return response()->json(['success' => true]);

    }

    public function getUsers(Request $request)
    {
        $user = auth()->user();
        $users = User::latest()->where("id", "!=", $user->id)->paginate(20);
        $res = [
            'success' => false,
            'message' => "something went wrong while getting users"
        ];
        if($users) {
            return UserResource::collection($users);
        }
        return response()->json($res);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
