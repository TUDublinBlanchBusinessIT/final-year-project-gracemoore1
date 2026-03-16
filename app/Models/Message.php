<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'message';

    protected $fillable = [
        'content',
        'timestamp',
        'studentid',
        'landlordid',
        'rentalid',
        'serviceproviderpartnershipid',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'studentid');
    }

    public function landlord()
    {
        return $this->belongsTo(Landlord::class, 'landlordid');
    }

    public function rental()
    {
        return $this->belongsTo(LandlordRental::class, 'rentalid');
    }
}