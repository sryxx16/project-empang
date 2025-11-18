<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FishingSpot extends Model
{
    use HasFactory;

    protected $guarded = []; // Ini biar kita bisa isi data langsung
}
