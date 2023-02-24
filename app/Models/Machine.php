<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class Machine extends Model
{
    use HasFactory;
    use Uuid;
    use SoftDeletes;

    protected $fillable = [
        'product_id', 'customer_id', 'status', 'description', 'date'
    ];

}
