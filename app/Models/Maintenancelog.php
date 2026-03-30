<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maintenancelog extends Model
{
    protected $table = 'maintenancelog';

    protected $fillable = [
        'description',
        'images',
        'status',
        'priority',
        'timestamp',
        'studentid',
        'rentalid',
        'applicationid',
        'landlordid',
    ];

    protected $casts = [
        'timestamp' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}