<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    // cadastrar usuário
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        //gera o token do sexo do user(token atual do usuario)
        $token = $user->createToken('token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ], 201);
    }

        public function login(Request $request){
            $credentials = $request->validate([
                'email' => '$required|string|email',
                'password' => 'required',
            ]);
            //faz a busca do user e pega o primeiro
            $user = User::where ('email', $request->email)->first();
            
            if(!$user || Hash::check($request->password,$user->password)){
                return response()->json(['message' => 'Credenciais inválidos'], 401);
            }
            $token = $user->createToken('token')->plainTextToken;
            return response()->json(['user' => $user, 'token' => $token]);
        }
    public function logout(Request $request){
     $request->user()->tokens()->delete();
     return response()->json(
        ['message' => 'Logout realizado com sucesso']);

}
}
?>