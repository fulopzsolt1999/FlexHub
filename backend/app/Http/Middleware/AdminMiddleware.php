<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $userId = $request->header('X-User-Id');
        $isAdmin = $request->header('X-Is-Admin');

        Log::info('Middleware ellenőrzés:', [
            'userId' => $request->header('X-User-Id'),
            'isAdmin' => $request->header('X-Is-Admin'),
        ]);

        if (!$userId || $isAdmin !== 'true') {
            Log::info('Felhasználó nem admin vagy nincs bejelentkezve.', [
                'userId' => $userId,
                'isAdmin' => $isAdmin,
            ]);
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
