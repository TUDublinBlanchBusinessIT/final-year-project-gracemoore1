<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Message;

class Application extends Model
{
    protected $table = 'application'; // or 'applications' if that's your actual table

    protected $fillable = [
        'applicationtype',
        'status',
        'dateapplied',
        'studentid',      // non-standard but matches your DB
        'rentalid',       // non-standard but matches your DB
        'age',
        'gender',
        'additional_details',
        'group_id',
    ];

    // Helpful relationships using your custom FK names
    public function student()
    {
        return $this->belongsTo(Student::class, 'studentid');
    }

    public function rental()
    {
        return $this->belongsTo(\App\Models\LandlordRental::class, 'rentalid');
    }

    public function group()
    {
        return $this->belongsTo(\App\Models\Group::class, 'group_id');
    }


    public function relatedMessages()
    {
        return $this->hasMany(Message::class, 'rentalid', 'rentalid')
            ->where('studentid', $this->studentid);
    }

} 