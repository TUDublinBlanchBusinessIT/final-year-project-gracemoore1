<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentPayment extends Model
{
    protected $table = 'rentpayment';

    protected $fillable = [
        'amount',
        'status',
        'stripe_intent_id',
        'timestamp',
        'rentalid',
        'studentid',
        'landlordid',
        'group_id',
        'application_id',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'timestamp' => 'datetime',
    ];

    public $timestamps = true;
}