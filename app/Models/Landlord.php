<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Landlord extends Model
{
    protected $table = 'landlord';
    public $timestamps = false;

    protected $fillable = [
        'firstname',
        'surname',
        'email',
        'phone',
        'password',
        'verified'
    ];
}


