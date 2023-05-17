<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->save();

        return response()->json(['message' => 'Registration successful'], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        // Generate the JWT token

        $payload = [
            'sub' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'iat' => time(),
            'exp' => time() + (60 * 120) // Token expires in 2 hours
        ];
        
        $token = JWT::encode($payload, config('jwt.secret'), 'HS256');
        
        // Return the token in the response headers
        return response()
            ->json(['message' => 'Login successful with token: ' . $token]);

        throw ValidationException::withMessages([
            'email' => 'Invalid credentials',
        ]);
    }

    public function delete(Request $request)
    {
        $request->user()->tokens()->delete();

        $token = $request->bearerToken();
        // Decodificar token JWT y validar firma
        try {
            $payload = JWT::decode($token, config('jwt.secret'), ['HS256']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Token inválido'], 401);
        }
        // Verificar que el usuario del token es el mismo que el usuario que se va a borrar
        $userId = $payload->sub;
        if ($userId != Auth::user()->id) {
            return response()->json(['error' => 'No tiene permisos para realizar esta acción'], 403);
        }
        // Borrar usuario
        $user = User::find(Auth::user()->id);
        if ($user) {
            $user->delete();
            return response()->json(['message' => 'Usuario eliminado correctamente'], 200);
        } else {
            return response()->json(['error' => 'El usuario no existe'], 404);
        }

    }
}
