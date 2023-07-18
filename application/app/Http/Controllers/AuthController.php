<?php

namespace App\Http\Controllers;

use App\Models\ActiveToken;
use App\Models\BlackListToken;
use App\Models\User;
use App\Services\FirebaseJwtAuth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    protected $firebaseJwtAuth;

    /**
     * @param $firebaseJwtAuth
     */
    public function __construct(FirebaseJwtAuth $firebaseJwtAuth)
    {
        $this->firebaseJwtAuth = $firebaseJwtAuth;
    }

    public function login(Request $request)
    {

        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            // Buscando o usuário com as credenciais fornecidas
            $user = User::where('email', $request->email)->first();
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json(['error' => 'Credenciais inválidas'], 401);
            }

            // Criando um token JWT para retornar ao cliente
            $token = $this->firebaseJwtAuth->createToken($user);

            // Remover da tabela de Tokens Ativos o Token do Usuario, medida de
            // segurança caso o usuário realize login mais de uma vez.
            $tokensDoUsuario = ActiveToken::where('user_id', $user->id)->get();

            if (!empty($tokensDoUsuario)) {
                foreach ($tokensDoUsuario as $tokenDoUsuario) {
                    BlackListToken::create(['token' => $tokenDoUsuario->token]);
                }
                ActiveToken::where('user_id', $user->id)->delete();
            }

            // Adicionar Token Gereado na tabela de Tokens ativos do Usuário.
            ActiveToken::create(['user_id' => $user->id, 'token' => $token]);

            return response()->json(['token' => $token, 'user' => $user]);
        } catch (ValidationException $e) {
            return new JsonResponse(
                ['errors' => $e->errors()],
                JsonResponse::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }

    public function me(Request $request)
    {
        return response()->json($request->user);
    }

    public function logout(Request $request)
    {
        $token = explode(' ', $request->header('Authorization'))[1];
        $user = $request->user;
        $tokensDoUsuario = ActiveToken::where('user_id', $user->id)->first();
        if (!empty($tokensDoUsuario)) {
            $tokensDoUsuario->delete();
        }
        BlackListToken::create(['token' => $token]);

        return response()->json(['message' => 'Logout efetuado com sucesso']);
    }
}
