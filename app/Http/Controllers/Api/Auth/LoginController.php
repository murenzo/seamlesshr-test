<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (! $token = auth()->attempt($credentials))
        {
            return response()->json(['error' => 'Incorrect credentials'], 400);
        }

        return response()->json(['token' => $token]);
    }

    // public function isLoggedIn()
    // {
    //     try {
    //         $user = auth()->userOrFail();
    //     } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
    //         return response()->json(['error' => $e->getMessage()]);
    //     }

    //     return $user->id;
    // }
}
