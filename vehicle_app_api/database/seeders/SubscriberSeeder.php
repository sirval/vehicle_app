<?php

namespace Database\Seeders;

use App\Models\Subscriber;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SubscriberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Subscriber::query()->delete();
        $subscribers = [
            ['api_id' => Str::uuid(), 'public_key' => 'custom_pub_test_'.Str::random(60), 'secret_key' => 'custom_secret_test_'.Str::uuid()],
            ['api_id' => Str::uuid(), 'public_key' => 'custom_pub_test_'.Str::random(60), 'secret_key' => 'custom_secret_test_'.Str::uuid()],
            ['api_id' => Str::uuid(), 'public_key' => 'custom_pub_test_'.Str::random(60), 'secret_key' => 'custom_secret_test_'.Str::uuid()],
            ['api_id' => Str::uuid(), 'public_key' => 'custom_pub_test_'.Str::random(60), 'secret_key' => 'custom_secret_test_'.Str::uuid()],
        ];
        foreach ($subscribers as $subscriber) {
            Subscriber::create($subscriber);
        }
    }
}
