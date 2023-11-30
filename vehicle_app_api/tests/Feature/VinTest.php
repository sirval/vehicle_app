<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\VehicleMockData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Tests\TestCase;

class VinTest extends TestCase
{
    use RefreshDatabase;

    public function test_an_authenticated_user_can_view_vin()
    {
        $data = [
            'vin' => '4F2YU09161KM33122', 
            'specification' => '{
                "vin": "4F2YU09161KM33122",
                "year": "2001",
                "make": "MAZDA",
                "model": "TRIBUTE",
                "trim_level": "LX",
                "engine": "3.0L V6 DOHC 24V",
                "style": "SPORT UTILITY 4-DR",
                "made_in": "UNITED STATES",
                "steering_type": "R&P",
                "anti_brake_system": "Non-ABS | 4-Wheel ABS",
                "tank_size": "16.40 gallon",
                "overall_height": "69.90 in.",
                "overall_length": "173.00 in.",
                "overall_width": "71.90 in.",
                "standard_seating": "5",
                "optional_seating": null,
                "highway_mileage": "24 miles/gallon",
                "city_mileage": "18 miles/gallon"
            }'
        ];
        $vin = VehicleMockData::create($data);
       $user = User::factory()->create();

       $token = JWTAuth::fromUser($user);
       
       $this->withHeaders([
           'Authorization' => 'Bearer ' . $token,
       ])->postJson('/api/v1/vehicle/vin', 
        ['vin' => $vin->vin]
       )
       ->assertStatus(200);
    }
}
