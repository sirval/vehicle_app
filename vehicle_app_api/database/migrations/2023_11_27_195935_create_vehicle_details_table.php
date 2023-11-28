<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vehicle_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('vin', 50);
            $table->string('year',8);
            $table->string('make', 100);
            $table->string('model', 100);
            $table->string('trim_level', 5);
            $table->string('engine', 100);
            $table->string('style', 100);
            $table->string('made_in', 100);
            $table->string('steering_type', 10);
            $table->string('anti_brake_system', 100);
            $table->string('tank_size', 20);
            $table->string('overall_height', 20);
            $table->string('overall_length', 20);
            $table->string('overall_width', 20);
            $table->string('standard_seating', 4);
            $table->string('optional_seating', 5)->nullable();
            $table->string('highway_mileage', 30);
            $table->string('city_mileage', 30);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_details');
    }
};
