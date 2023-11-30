<?php

namespace Tests\Feature;

use App\Constants;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\JWT;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
        $this->seed();
    }

    public function test_a_user_can_login_with_phone_number_and_password()
    {
        $user = User::factory()->create();
        $response = $this->postJson('api/v1/auth/login', [
            'phone' => $user->phone,
            'password' => 'password'
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'user',
                    'authorization'
                ]
            ]);
        $this->assertAuthenticated();
        $this->assertAuthenticatedAs($user);
    }
    

    public function test_a_user_cannot_login_with_incorrect_credential()
    {
        $user = User::factory()->create();
        $user->whereId($user->id)->update([
            'is_verified' => Constants::IS_NOT_VERIFIED_USER
        ]);
        $user->refresh();
        $this->postJson('api/v1/auth/login', [
            'phone' => $user->phone,
            'password' => 'password',
        ])->assertOk();
    }

    public function test_a_user_cannot_login_if_not_verified()
    {
        $user = User::factory()->create();
        
        $this->postJson('api/v1/auth/login', [
            'phone' => $user->phone,
            'password' => 'invalid-password',
        ]);
        
        $this->assertGuest();
    }

    public function test_a_user_can_access_authenticated_routes_when_logged_in()
    {
        $user = User::factory()->create();

        $token = JWTAuth::fromUser($user);
        
        $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/v1/auth/me')
        ->assertStatus(200);
    }

    public function test_a_user_can_refresh_token()
    {
        $user = User::factory()->create();

        $token = JWTAuth::fromUser($user);
        
        $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/v1/auth/refresh')
        ->assertStatus(200);
    }
}
