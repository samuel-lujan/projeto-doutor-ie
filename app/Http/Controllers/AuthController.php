<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\StoreUserRequest;
use App\Services\Auth\AuthService;
use Exception;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    private AuthService $authService;


    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function store(StoreUserRequest $request)
    {
        $attributes = $request->validated();

        try {
            $userService = $this->authService->register($attributes);

            $user = $userService['data'];

            // Cria um novo token de acesso para tal usuário criado
            $token = $user->createToken('access_token')->plainTextToken;

            $response = [
                'success'   =>  true,
                'user'      =>  $user,
                'token'     =>  $token,
            ];
        } catch (Exception $e) {
            Log::error("Houve uma falha ao cadastrar um novo usuário: {$e->getMessage()}", $e->getTrace());
            return response()->json([
                'success' => false,
                'message' => "Houve uma falha ao cadastrar o novo usuário"
            ], 400);
        }

        return response()->json($response, 201);
    }

    public function login(LoginRequest $request) {
        $attributes =   $request->validated();
        try {
            $loginService = $this->authService->login($attributes['email'], $attributes['password']);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode());
        }

        $user = $loginService['data'];

        $token = $user->createToken('access_token')->plainTextToken;

        return response()->json([
            'success'   =>  true,
            'message'   =>  "Login efetuado com sucesso",
            'token'     =>  $token,
            'user'      =>  $user,
        ], 200);
    }
}
