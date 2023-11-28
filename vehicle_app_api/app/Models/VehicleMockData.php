<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleMockData extends Model
{
    use HasFactory;

    protected $casts = [
        'subscription' => 'array'
    ];
}
