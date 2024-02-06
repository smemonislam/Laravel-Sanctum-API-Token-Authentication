<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Notification;
use App\Notifications\EmailVerificationNotification;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(RegisterRequest $request)
    {
        $user = User::create($request->only('name', 'email', 'password'));

        $url = URL::temporarySignedRoute('email.verify', now()->addMinutes(30), ['email' => $user->email]);
        $url = str_replace(env('APP_URL'), env('FRONTEND_URL'), $url);
        Notification::send($user, new EmailVerificationNotification($url));

        return response()->json(
            [
                'status' => 'success',
                'message' => 'Registration was successfully registered.',
            ],
            200,
        );
    }
}
