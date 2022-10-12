<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login()
    {
        $user = User::factory()->create();

        $this->postJson('/api/v1/auth/token', [
            'email'     =>  $user->email,
            'password'  =>  "password",
        ])->assertJsonStructure([
            'success',
            'message',
            'token',
            'user',
        ])->assertStatus(200);
    }

    public function test_user_can_not_login_with_invalid_credentials()
    {
        $user = User::factory()->create();

        $this->postJson('/api/v1/auth/token', [
            'email'     =>  $user->email,
            'password'  =>  "passwordsss",
        ])->assertJsonStructure([
            'success',
            'message',
        ])->assertStatus(401);
    }
}
