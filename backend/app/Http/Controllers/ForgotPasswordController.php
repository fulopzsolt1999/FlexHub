<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'A megadott e-mail cím nem található.'], 404);
        }

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => now()]
        );

        $resetLink = env('FRONTEND_URL') . '/reset-password?token=' . $token;

        Mail::send('emails.password_reset', ['resetLink' => $resetLink], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Jelszó visszaállítás');
        });

        return response()->json(['message' => 'Jelszó visszaállítási link elküldve az e-mail címre.']);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $reset = DB::table('password_reset_tokens')->where('token', $request->token)->first();

        if (!$reset) {
            return response()->json(['message' => 'Érvénytelen vagy lejárt token.'], 400);
        }

        $user = User::where('email', $reset->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Felhasználó nem található.'], 404);
        }

        $user->update(['password' => Hash::make($request->password)]);

        DB::table('password_reset_tokens')->where('email', $reset->email)->delete();

        return response()->json(['message' => 'Jelszó sikeresen megváltoztatva.']);
    }
}
