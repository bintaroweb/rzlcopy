<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryDetail extends Model
{
    use HasFactory;
    use Uuid;
    use SoftDeletes;

    public $table = 'delivery_details';

    protected $fillable = [
        'total', 'product_id', 'delivery_id', 'type', 'description'
    ];
}
