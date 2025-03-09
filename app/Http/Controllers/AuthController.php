<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }
    // Register User
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'no_hp' => 'required|string',
            'role' => 'required|string'
        ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'no_hp' => $request->no_hp,
            'role' => $request->role,
        ]);

        // $token = $user->createToken('auth_token')->plainTextToken;
        Auth::login($user); // Login user setelah register

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'User registered successfully',
                'user' => $user,
                'token' => $user->createToken('auth_token')->plainTextToken,
            ], 201);
        }

        // if ($request->expectsJson()) {
        //     return response()->json([
        //         'message' => 'User registered successfully',
        //         'user' => $user,
        //         'token' => $user->createToken('auth_token')->plainTextToken,
        //     ], 201);
        // }

        // return redirect()->route('welcome'); // Redirect jika bukan API
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    // Login User
    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'user' => $user,
            'token' => $token
        ]);
    }

    // Logout User
    public function logout(Request $request)
    {
        // // Hapus token akses Sanctum
        // $request->user()->currentAccessToken()->delete();
    
        // // Logout user dan hapus session
        // Auth::logout();
        // $request->session()->invalidate();
        // $request->session()->regenerateToken();
    
        // // Redirect ke halaman welcome
        // return redirect('/welcome');
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }
    
}


