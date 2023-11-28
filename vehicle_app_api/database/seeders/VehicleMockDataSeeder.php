<?php

namespace Database\Seeders;

use App\Models\VehicleMockData;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleMockDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VehicleMockData::query()->delete();
        $mockData = [
            [
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
            ],
            [
                'vin' => 'JT4RN81P1M5078565', 
                'specification' => '{
                    "vin": "JT4RN81P1M5078565",
                    "year": "1991",
                    "make": "TOYOTA",
                    "model": "PICKUP",
                    "trim_level": "DX",
                    "engine": "2.4L L4 SOHC 8V",
                    "style": "EXTENDED CAB PICKUP 2-DR",
                    "made_in": "JAPAN",
                    "steering_type": "R&P",
                    "anti_brake_system": "Non-ABS",
                    "tank_size": "18.50 gallon",
                    "overall_height": "64.80 in.",
                    "overall_length": "193.00 in.",
                    "overall_width": "66.50 in.",
                    "standard_seating": "3",
                    "optional_seating": null,
                    "highway_mileage": "21 miles/gallon",
                    "city_mileage": "16 miles/gallon"
                }'
            ],
            [
                'vin' => '1HGCM56743A101083', 
                'specification' => '{
                    "vin": "1HGCM56743A101083",
                    "year": "2003",
                    "make": "HONDA",
                    "model": "ACCORD",
                    "trim_level": "LX",
                    "engine": "3.0L V6 SOHC 24V",
                    "style": "SEDAN 4-DR",
                    "made_in": "UNITED STATES",
                    "steering_type": "R&P",
                    "anti_brake_system": "4-Wheel ABS",
                    "tank_size": "17.10 gallon",
                    "overall_height": "56.90 in.",
                    "overall_length": "189.50 in.",
                    "overall_width": "71.50 in.",
                    "standard_seating": "5",
                    "optional_seating": null,
                    "highway_mileage": "29 miles/gallon",
                    "city_mileage": "20 miles/gallon"
                }'
            ],
            [
                'vin' => '1G1JC124417321654', 
                'specification' => '{
                    "vin": "1G1JC124417321654",
                    "year": "2001",
                    "make": "CHEVROLET",
                    "model": "CAVALIER",
                    "trim_level": "LS",
                    "engine": "2.2L L4 DOHC 16V",
                    "style": "COUPE 2-DR",
                    "made_in": "UNITED STATES",
                    "steering_type": "R&P",
                    "anti_brake_system": "4-Wheel ABS",
                    "tank_size": "14.10 gallon",
                    "overall_height": "53.70 in.",
                    "overall_length": "180.50 in.",
                    "overall_width": "68.70 in.",
                    "standard_seating": "5",
                    "optional_seating": null,
                    "highway_mileage": "33 miles/gallon",
                    "city_mileage": "24 miles/gallon"
                  }'
            ],
            [
                'vin' => '5N1AR18U98C652305', 
                'specification' => '{
                    "vin": "5N1AR18U98C652305",
                    "year": "2008",
                    "make": "NISSAN",
                    "model": "XTERRA",
                    "trim_level": "SE",
                    "engine": "4.0L V6 DOHC 24V",
                    "style": "SPORT UTILITY 4-DR",
                    "made_in": "UNITED STATES",
                    "steering_type": "R&P",
                    "anti_brake_system": "4-Wheel ABS",
                    "tank_size": "21.10 gallon",
                    "overall_height": "74.90 in.",
                    "overall_length": "178.70 in.",
                    "overall_width": "72.80 in.",
                    "standard_seating": "5",
                    "optional_seating": null,
                    "highway_mileage": "20 miles/gallon",
                    "city_mileage": "15 miles/gallon"
                  }'
            ]
        ];
        foreach ($mockData as $data) {
            VehicleMockData::create([
                'vin' => $data['vin'],
                'specification' => $data['specification']
            ]);
        }
    }
}
