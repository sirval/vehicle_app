<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->delete();
        $users = [
            ['name' => 'Ikenna Valentine', 'phone' => '+2349000000001', 'verif_code' => '000001', 'is_verified' => 1, 'verif_expires_at' => Carbon::now()->addMinutes(30), 'phone_verified_at' => Carbon::now(), 'password' => Hash::make('password')],
            ['name' => 'John Doe', 'phone' => '+2349000000005', 'verif_code' => '000005', 'is_verified' => 1, 'verif_expires_at' => Carbon::now()->addMinutes(10), 'phone_verified_at' => Carbon::now(), 'password' => Hash::make('password')],
            ['name' => 'John Ken', 'phone' => '+2349000000006', 'verif_code' => '000006', 'is_verified' => 1, 'verif_expires_at' => Carbon::now()->addMinutes(10), 'phone_verified_at' => Carbon::now(), 'password' => Hash::make('password')],
            ['name' => 'Chris James', 'phone' => '+2349000000007', 'verif_code' => '000007', 'is_verified' => 1, 'verif_expires_at' => Carbon::now()->addMinutes(10), 'phone_verified_at' => Carbon::now(), 'password' => Hash::make('password')],
        ];
        foreach ($users as $user) {
            User::create($user);
        }
    }
}
