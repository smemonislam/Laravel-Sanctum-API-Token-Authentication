<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(LoginRequest $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember_token)) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Login successful.',
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                ],
                200,
            );
        }

        return response()->json(
            [
                'status' => 'error',
                'message' => 'User Not Found!',
            ],
            200,
        );
    }
}
