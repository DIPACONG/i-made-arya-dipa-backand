<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * REGISTER BARU (Sesuai Bab 3.4.7 Modul)
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message'    => 'Register success',
            'user'       => $user,
            'token'      => $token,
            'token_type' => 'Bearer',
        ], 201);
    }

    /**
     * LOGIN PENGGUNA (Sesuai Bab 3.4.7 Modul)
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials.'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message'    => 'Login success',
            'user'       => $user,
            'token'      => $token,
            'token_type' => 'Bearer',
        ]);
    }

    /**
     * PROFILE PENGGUNA AKTIF (Sesuai Bab 3.4.7 Modul)
     */
    public function profile(Request $request)
    {
        return response()->json($request->user());
    }

    /**
     * LOGOUT PENGGUNA (Sesuai Bab 3.4.7 Modul)
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout success']);
    }
}
