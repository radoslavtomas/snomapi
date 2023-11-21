<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Laravel\Fortify\Contracts\ResetsUserPasswords;

class PasswordController extends Controller
{
    public function postForgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'reset_url' => 'required|url'
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return [
            'success' => $status === Password::RESET_LINK_SENT,
            'message' => __($status)
        ];
    }

    public function postResetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user) use ($request) {
                app(ResetsUserPasswords::class)->reset($user, $request->all());

                event(new PasswordReset($user));
            }
        );

        return [
            'success' => $status === Password::PASSWORD_RESET,
            'message' => __($status)
        ];
    }
}
