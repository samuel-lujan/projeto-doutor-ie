<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register()
    {
        $this->postJson("/api/v1/user", [
            "name"      =>  "Esther Pietra Vieira",
            "email"     =>  "estherpietravieira@autbook.com",
            "password"  =>  "admin1234",
            "password_confirmation" => "admin1234",
        ])->assertCreated();

        $this->assertDatabaseHas("users", ['email' => 'estherpietravieira@autbook.com']);
    }

}
