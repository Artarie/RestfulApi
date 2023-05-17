<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {


        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        $user = new User([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $user->save();

        return response()->json(['message' => 'Registration successful'], 201);
    }

    public function login(Request $request)
    {



        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $payload = [
                'sub' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'iat' => time(),
                'exp' => time() + (60 * 120) // Token expires in 2 hours
            ];

            $token = JWT::encode($payload, env('JWT_SECRET'), 'HS256');
            
            // Return the token in the response headers
            return response()
                ->json(['message' => 'Login successful with token: ' . $token]);
        } else {

            return response()
                ->json(['message' => 'No user found, please check your email and password.']);
        }
    }

    public function logout(Request $request)
    {
        $token = $request->bearerToken();
        $user = Auth::user();
        $payload = JWT::decode($token, env('JWT_SECRET'), 'HS256');
    
       auth()->logout();
        return response()
        ->json(['message' => 'Succesful logout, removing token']);
    }
}
