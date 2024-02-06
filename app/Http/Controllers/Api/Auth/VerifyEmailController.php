<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VerifyEmailController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user) {
            $user->forceFill([
                'email_verified_at' => now()
            ]);

            $user->save();

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Email verification successfully.',
                ],
                200,
            );
        }

        return response()->json(
            [
                'status' => 'error',
                'message' => 'User Not Found',
            ],
            401
        );

    }
}
