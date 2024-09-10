<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('roles')->orderBy('created_at', 'desc')->get();
        return response($users,200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'uid' => 'required|unique:users',
            'name' => 'required|string|max:255',
            'email' => 'required|string|unique:users,email',
        ]);

        if($validator->fails()){
            $data = [
                'message'=> 'error',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data,400);
        }

        $user = User::create([
            'uid' => $request->uid,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->uid),
            'phone' => $request->phone,
            'address' => $request->address,
            'status'  => $request->status,
        ]);

        $user->assignRole($request->role);

        return response($user, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::find($id);
        $user->getRoleNames();

        return response($user, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $validator = Validator::make($request->all(), [
            'uid' => ['required',
                Rule::unique('users')->ignore($user->id),
            ],
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
        ]);

        if($validator->fails()){
            $data = [
                'message'=> 'error',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data,400);
        }

        $user->update([
            'uid' => $request->uid,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->uid),
            'phone' => $request->phone,
            'address' => $request->address,
            'status'  => $request->status,
        ]);

        $roleString = sprintf("'%s'", $request->role);

        $user->assignRole($roleString);

        return response($user, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->update([
            'status' => 'Delete'
        ]);

        return response($user, 200);
    }

    public function search($select, $param)
    {
        $users = User::where($select, 'like', '%'.$param.'%')->get();

        return response($users, 200);
    }
}
