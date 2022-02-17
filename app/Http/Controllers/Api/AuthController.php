<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sentinel;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function login( Request $request )
    {
        $credentials = request(['email', 'password']);
        if ( !$token = auth()->attempt($credentials) ) {
            return response()->json([
                'status' => false,
                'message' => [
                    'type' => 'warning',
                    'title' => 'Error autenticación',
                    'description' => 'Usuario o contraseña inválidos',
                ]
            ]);
        }
            
        $user = Sentinel::authenticate( $credentials ) ;

        return response()->json([
            'status' => true,
            'message' => [
                'type' => 'success',
                'title' => 'Autenticado',
                'description' => 'Ha iniciado sesión correctamente',
            ],
            'token' => $token,
            'user' => $user
        ]);
    }
    public function logout()
    {
        auth()->logout();
        return response()->json([
            'status' => true,
            'message' => [
                'type' => 'success',
                'title' => 'Logout',
                'description' => 'Ha cerrado sesión',
            ],
        ]);
    }
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
