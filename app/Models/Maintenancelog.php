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
        'landlord_note',
        'landlord_image',
        'priority',
        'timestamp',
        'studentid',
        'rentalid',
        'applicationid',
        'landlordid',
        'is_seen_by_landlord',
    ];

    protected $casts = [
        'timestamp' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}