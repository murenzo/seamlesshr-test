<?php

namespace App\Http\Controllers\Api\Auth;

use App\Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;
use App\Course;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['status' => 400, 'message' => 'Incorrect credentials'], 400);
        }

        return response()->json(['status' => 200, 'message' => 'Login successful', 'data' => ['token' => $token]]);
    }
}
