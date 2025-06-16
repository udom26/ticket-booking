<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'flight_data',
        'passenger_data',
        // เพิ่ม field อื่นๆ ถ้ามี
    ];
}
