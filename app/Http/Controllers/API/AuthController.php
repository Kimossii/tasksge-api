<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    //
    function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email:rfc,dns|max:255|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);


        $user = User::create(
            [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]
        );
        $token = $user->createToken('api-token', ['post:read', 'post:create'])->plainTextToken;

        return response()->json(['ok' => true, 'user' => $user, 'token' => $token]);
    }
    function login(Request $request)
    {

        $validated = $request->validate([
            'email' => 'required|string|email:rfc,dns',
            'password' => 'required|min:8',
        ]);

        if(Auth::attempt($validated)){
            $user = User::where('email', $validated['email'])->first();
           $token = $user->createToken('api-token', ['post:read', 'post:create'])->plainTextToken;

            return response()->json(['ok' => true, 'token' => $token]);
        }
        return response()->json(['ok' => false, 'mensagem'=> 'Credencias inválidas'], 401);
    }
    function logout(Request $request)
    {
       $token = $request->bearerToken();
       if(!$token){
              return response()->json(['ok' => false, 'mensagem' => 'Token não fornecido'], 401);
       }
       $access_token = PersonalAccessToken::findToken($token);
       if(!$access_token){
              return response()->json(['ok' => false, 'mensagem' => 'Token fornecido é inválido'], 401);
       }
         $access_token->delete();
         return response()->json(['ok' => true, 'mensagem' => 'Logout realizado com sucesso']);
    }
}
