<?php

namespace Tests\Feature;

use App\Constants;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Mockery\MockInterface;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public $sendSms;
    public $apiResponse;
    public $generateVerificationCode;
    // protected function setUp(): void
    // {
    //     parent::setUp();
    //     $this->apiResponse = $this->partialMock(ApiResponse::class, function(MockInterface $mock) {
    //         $mock->shouldReceive('response')->andReturn([
    //             'data', 'statusCode','status', 'response'
    //         ]);
    //     });

    //     $this->sendSms = $this->partialMock(Utils::class, function(MockInterface $mock) {
    //         $mock->shouldReceive('sendSms')->andReturn($user);
    //     });
    // }
    
    public function test_a_user_can_register()
    {
        $data = [
            'name' => 'John Doe',
            'phone' => '+2349011111111',
            'verif_code' => '111111',
            'verif_expires_at' =>  Carbon::now()->addMinutes(30),
            'password' => Hash::make('password'),
        ];
        $this->postJson('api/v1/auth/register', 
        $data)->assertOk();
    }

    public function test_a_user_receives_verification_code_after_registration()
    {
        $phone = '+2349011111111';
        $this->generateVerificationCode = $this->partialMock(Utils::class, function(MockInterface $mock) use ($phone) {
            $mock->shouldReceive('generateVerificationCode')->andReturn($phone);
        });
        $data = [
            'name' => 'John Doe',
            'phone' => $phone,
            'verif_code' => $this->generateVerificationCode,
            'verif_expires_at' =>  Carbon::now()->addMinutes(30),
            'password' => Hash::make('password'),
        ];
        $user = $this->postJson('api/v1/auth/register', 
            $data
        );
       
        $this->sendSms = $this->partialMock(Utils::class, function(MockInterface $mock) use ($user) {
            $mock->shouldReceive('sendSms')->andReturn($user);
        });

        $this->assertIsBool(true);
    }

    public function test_unverified_user_can_verify_after_registration()
    {
        $phone = '+2349011111111';
        $this->generateVerificationCode = $this->partialMock(Utils::class, function(MockInterface $mock) use ($phone) {
            $mock->shouldReceive('generateVerificationCode')->andReturn($phone);
        });
        $data = [
            'name' => 'John Doe',
            'phone' => $phone,
            'verif_code' => $this->generateVerificationCode,
            'verif_expires_at' =>  Carbon::now()->addMinutes(30),
            'is_verified' => Constants::IS_NOT_VERIFIED_USER,
            'password' => Hash::make('password'),
        ];
        $this->postJson('api/v1/auth/register', 
            $data
        );
        $this->postJson('api/v1/auth/verify-code', [
            'verify_code' => $this->generateVerificationCode
        ])->assertStatus(200);

    }
}
