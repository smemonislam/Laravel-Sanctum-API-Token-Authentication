<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ResetPasswordNotification;

class ForgotPasswordController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(ForgotPasswordRequest $request)
    {
        $users = User::where('email', $request->email)->first();
        $url = URL::temporarySignedRoute('password.update', now()->addMinutes(30), ['email' => $users->email]);
        $url = str_replace(env('APP_URL'), env('FRONTEND_URL'), $url);
        Notification::send($users, new ResetPasswordNotification($url));

        return response()->json(
            [
                'status' => 'success',
                'message' => 'Reset Password Link was sent successfully.',
            ],
            200,
        );
    }
}
