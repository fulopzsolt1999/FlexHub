<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            User::create([
                'user_name' => $request->user_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return response()->json(['message' => 'Sikeres regisztráció!'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Hiba történt a regisztráció során.', 'error' => $e->getMessage()], 500);
        }
    }

    public function login(Request $request)
    {
        $user = User::where('user_name', $request->user_name)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Nem megfelelőek az adatok.'], 401);
        }

        try {
            return response()->json(['message' => 'Sikeres bejelentkezés!', 'user' => $user], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Hiba történt a bejelentkezés során.', 'error' => $e->getMessage()], 500);
        }
    }
}
