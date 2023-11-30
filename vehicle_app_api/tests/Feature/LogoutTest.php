<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;
    public function test_a_user_can_logout()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/v1/auth/logout')
            ->assertOk();
    }
}
