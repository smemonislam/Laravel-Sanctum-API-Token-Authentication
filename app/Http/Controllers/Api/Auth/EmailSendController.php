<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmailSendRequest;
use Illuminate\Support\Facades\Notification;
use App\Notifications\EmailVerificationNotification;

class EmailSendController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(EmailSendRequest $request)
    {
        $users = User::where('email', $request->email)->first();
        $url = URL::temporarySignedRoute('email.verify', now()->addMinutes(30), ['email' => $users->email]);
        $url = str_replace(env('APP_URL'), env('FRONTEND_URL'), $url);
        Notification::send($users, new EmailVerificationNotification($url));

        return response()->json(
            [
                'status' => 'success',
                'message' => 'Email verification Link was sent successfully.',
            ],
            200,
        );
    }
}
