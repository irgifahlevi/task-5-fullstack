<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        $validasi = $request->validate([

            'name'  => 'required|max:55',
            'email' => 'email|required|unique:users',
            'password' => 'required|confrimed'
        ]);


        $validasi['password'] = Hash::make($request->password);

        $user = User::create($validasi);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response(['user' => $user, 'access_token' => $accessToken], 201);
    }

    public function login(Request $request)
    {

        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($loginData)) {
            return response(['message' => 'This User does not exist, check your details'], 400);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;
        return response(['user' => auth()->user(), 'accessToken' => $accessToken]);
    }
}
