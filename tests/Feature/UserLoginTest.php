<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class UserLoginTest extends TestCase
{
    public function test_login_as_user_with_email_password()
    {
        $user = User::first();
        $this->postJson('/profile/login', ['email' => $user->email, 'password' => '123123'])
            ->assertStatus(302);
    }
}
