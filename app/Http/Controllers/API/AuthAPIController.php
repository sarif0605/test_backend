<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthAPIController extends Controller
{
    public function register(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string',
                'email' => 'required|string|email|unique:users',
                'password' => 'required|string|confirmed'
            ]);

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'email_verified_at' => now(),
                'password' => Hash::make($data['password']),
                'role' => 'user'
            ]);

            $token = JWTAuth::fromUser($user);

            return response()->json([
                'success' => true,
                'message' => 'Registrasi berhasil',
                'data' => [
                    'user' => $user,
                    'token' => $token,
                    'token_type' => 'Bearer',
                ],
                'errors' => []
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'data' => [],
                'errors' => $e->errors(),
            ], 422);
        }
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        if (!$token = auth()->attempt($data)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah',
                'data' => []
            ], 401);
        }
        $userData = User::where('email', $data['email'])->first();
        $token = JWTAuth::fromUser($userData);
        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'data' => [
                'user' => $userData,
                'token' => $token,
                'token_type' => 'Bearer'
            ],
            'errors' => []
        ], 200);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil',
        ], 200);
    }

}