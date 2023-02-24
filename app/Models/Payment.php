<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class Payment extends Model
{
    use HasFactory;
    use Uuid;

    protected $fillable = [
        'user_id', 'outlet_id', 'payment_method', 'created_by' 
    ];
}
