<?php

namespace App\Models;

use App\Traits\UserId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory;
    use Uuid;
    use SoftDeletes;

    protected $fillable = [
        'uuid', 'customer_name', 'customer_phone', 'customer_email', 'date',
        'customer_address', 'customer_city', 'customer_note' , 'customer_status', 'customer_company'
    ];

}
