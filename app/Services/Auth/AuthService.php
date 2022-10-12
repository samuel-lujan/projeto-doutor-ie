<?php

namespace App\Services\Auth;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    /**
     * This Method Will Register a new user
     * @param array $userData
     * @return array
     * @throws \Exception
     */
    public function register(array $userData):array {

        $userData['password'] = bcrypt($userData['password']);

        $user = User::create($userData);

        return [
            'sucess' => true,
            'message' => "Usuário cadastrado com sucesso",
            'data' => $user,
        ];
    }

    /**
     * This Method will find a registered user and check his password for login
     * @param string $email
     * @param string $password
     * @return array
     * @throws \Exception
     */
    public function login(string $email, string $password): array {
        $user = User::where('email', $email)->first();

        if (! $user )
            throw new Exception("Nenhum usuário foi encontrado com esse email", 404);


        if (! Hash::check($password, $user->password) )
            throw new Exception("Usuário e senha não correspondentes", 401);

        return [
            'success' => true,
            'message' => 'Usuário logado com sucesso',
            'data'    => $user,
        ];

    }
}
