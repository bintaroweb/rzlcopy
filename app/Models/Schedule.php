<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class Schedule extends Model
{
    use HasFactory;
    use Uuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'date',
        'customer_id',
        'technician_id',
        'contact',
        'address',
        'problem'
    ];
}
