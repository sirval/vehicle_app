<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\JWT;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp();

        // Run migrations for the test database
        $this->artisan('migrate');
        // Call the database seeder
        $this->seed();
    }
    

    public function test_user_cannot_login_with_incorrect_credential()
    {
        $user = User::factory()->create();
        
        $this->post('api/v1/auth/login', [
            'phone' => $user->phone,
            'password' => 'invalid-password',
        ]);
        
        $this->assertGuest();
    }

    public function test_user_can_access_authenticated_routes_when_logged_in()
    {
        $user = User::factory()->create();
        $payload = [
            'phone' => $user->phone,
            'password' => 'password'
        ];

        $token = JWTAuth::encode($payload, config('jwt.secret'));
        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('/api/', [
            'phone' => $user->phone,
            // Other request parameters
        ]);
    }

    public function it_returns_authenticated_user_data()
    {
        // Create a user
        $user = User::factory()->create();

        // Generate a JWT token for the user
        $token = JWTAuth::fromUser($user);

        // Hit an authenticated route using the token
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            // Other necessary headers
        ])->get('/your-authenticated-route');

        // Assert that the response should be successful (status code 200)
        $response->assertStatus(200);

        // Assert other response content or data returned from the authenticated route
        // For example:
        $response->assertJson([
            'message' => 'Authenticated route accessed successfully',
        ]);
    }
}
