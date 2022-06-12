<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function signup(Request $request) {
        error_log($request->input('password'));
        error_log($request->input('confirmation'));
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'name' => $fields["name"],
            'email' => $fields["email"],
            'password' => bcrypt($fields["password"])
        ]);

        $token = $user->createToken('laravel_test_app')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function login(Request $request) {
        $fields = $request->validate([
            'email' => 'string',
            'password' => 'string'
        ]);

        $user = User::firstWhere('email', $fields['email']);

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Bad credentials'
            ], 401);
        }

        $token = $user->createToken('laravel_test_app')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token
        ];
    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();

        return [
            'message' => 'Logged out'
        ];
    }
}
