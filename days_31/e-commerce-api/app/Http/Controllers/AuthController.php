<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();

            return response()->json([
                'success' => false,
                'msg' => $errors,
            ], 422);
        }

        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'role' => 'user',
        ]);

        return response()->json(['success' => true, 'msg' => 'user registration successfully']);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();

            return response()->json([
                'success' => false,
                'msg' => $errors,
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['msg' => 'Unauthorized'], 401);
        }

        $token = $this->generateToken($user);
        return response()->json(['success' => true, 'token' => $token], 200);
    }

    private function generateToken(User $user)
    {
        $payload = [
            'sub' => $user->id,
            'role' => $user->role,
            'iat' => time(),
            'exp' => time() + (60 * 60)
        ];

        return JWT::encode($payload, env('JWT_SECRET'), 'HS256');
    }
}
