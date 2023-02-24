<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class Record extends Model
{
    use HasFactory;
    use Uuid;
    use SoftDeletes;

    protected $fillable = [
        'customer_id', 'date', 'problem', 'description', 'counter', 'technician_id', 'machine_id', 'source'
    ];
}
