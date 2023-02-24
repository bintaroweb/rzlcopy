<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class Outlet extends Model
{
    use HasFactory;
    use Uuid;

    protected $fillable = [
        'user_id', 'name', 'province_id', 'city_id', 'district_id', 'phone', 'address', 'created_by' 
    ];
}
