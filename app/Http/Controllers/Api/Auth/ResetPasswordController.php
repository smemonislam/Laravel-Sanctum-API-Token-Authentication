<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ResettPasswordRequest;

class ResetPasswordController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(ResettPasswordRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user) {
            $user
                ->forceFill([
                    'password' => Hash::make($request->password),
                ])
                ->setRememberToken(Str::random(60));

            $user->save();
        }

        return response()->json(
            [
                'status' => 'success',
                'message' => 'Reset Password updated successfully.',
            ],
            200,
        );
    }
}
