<?php

namespace App\Http\Middleware;

use Closure;
use Firebase\JWT\JWT;
use App\Models\User;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\Key;

class AuthMiddleware
{
    public function handle($request, Closure $next)
    {
        $token = $request->header('Authorization');

        if (!$token) {
            return response()->json(['success' => false, 'msg' => 'Token not provided'], 401);
        }

        try {
            $token = explode(' ', $token)[1];
            $decoded = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));

            $user =  User::where('id', $decoded->id)->exists();

            if (!$user) {
                return response()->json(['error' => 'User not found'], 401);
            }

            $request->auth = $decoded;
        } catch (ExpiredException $e) {
            return response()->json(['success' => false, 'msg' => 'Token expired'], 401);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => 'Invalid token'], 401);
        }

        return $next($request);
    }
}
