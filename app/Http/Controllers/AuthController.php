<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
        ])->validate();

        $user  = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => Hash::make($fields['password']),
        ]);

        $user->assignRole('USER');

        $token = $user->createToken($user->name);

        $data = [
            'user' => $user,
            'token' => $token->accessToken
        ];

        return response($data, 200);

    }

    public function login(Request $request)
    {
        $fields = Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required|string',
        ])->validate();

        $user = User::where('email',$fields['email'])->first();

        if(!$user || !Hash::check($fields['password'], $user->password)){
            return response([
                'noti' => 'Invalid login credential!!'
            ], 401);
        }

        $token = $user->createToken($user->name);

        $data = [
            'user' => $user,
            'token' => $token->accessToken
        ];

        return response($data, 200);

    }

    public function logout(Request $request)
    {
        $this->validate($request, [
            'allDevice' => 'required|boolean'
        ]);

        $user = Auth::user();
        if ($request->allDevice) {
            $user->tokens->each(function ($token) {
                $token->delete();
            });
            return response(['message' => 'Logged out from all device !!'], 200);
        }

        $userToken = $user->token();
        $userToken->delete();
        return response(['message' => 'Logged Successful !!'], 200);

    }

    public function checkToken(){
        $user = Auth::user();
        $token = $user->createToken($user->name);

        $data = [
            'user' => $user,
            'token' => $token->accessToken
        ];

        return response($data, 200);
    }

    public function userByRelations($id){

        $user = User::find($id);
        $data = [
            'status' => 201,
            'message' => 'User by Relations.',
            'finances' => $user->finances,
            'obligations' => $user->obligations
        ];

        return response()->json($data,201);
    }

}
