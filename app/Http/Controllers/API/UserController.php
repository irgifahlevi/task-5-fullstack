<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class UserController extends Controller
{
    public function login(Request $request)
    {

        $input = $request->all();
        $validasi = Validator::make(
            $input,
            [
                // 'name'  => 'required|max:55',
                'email'     => 'required|email',
                'password'  => 'required'
            ]
        );

        if ($validasi->fails()) {
            return response()->json(['error' => $validasi->errors()], 422);
        }

        if (Auth::attempt(['email' => $input['email'], 'password' => $input['password']])) {
            $user   = Auth::user();
            $token  = $user->createToken('Coba_Token');

            // return response()->json(['token' => $token]);

            return response()->json([
                'token' => $token->accessToken,
                'expires_at' => Carbon::parse($token->token->expires_at)->toDateTimeString()
            ], 200);
        } else {
            return response([
                "message" => "Unauthorised."
            ], 401);
        }
    }





    public function aboutMe()
    {
        $user = Auth::guard('api')->user();
        return response()->json(['data' => $user]);
    }



    public function logout(Request $request)
    {

        $request->user()->tokens->each(function ($token) {
            $this->revokeAccessAndRefreshTokens($token->id);
        });

        return response()->json('Logged out successfully', 200);
    }

    protected function revokeAccessAndRefreshTokens($tokenId)
    {
        $tokenRepository = app('Laravel\Passport\TokenRepository');
        $refreshTokenRepository = app('Laravel\Passport\RefreshTokenRepository');

        $tokenRepository->revokeAccessToken($tokenId);
        $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($tokenId);
    }
}
