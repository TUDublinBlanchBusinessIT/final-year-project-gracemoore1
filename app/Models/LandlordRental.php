<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandlordRental extends Model
{
    protected $table = 'rental';      
    public $timestamps = false;       
    protected $fillable = [
        'housenumber',
        'street',
        'county',
        'postcode',
        'description',
        'measurement',
        'housetype',
        'accommodation_type',
        'nightsperweek',
        'rentpermonth',
        'images',
        'status',
        'availablefrom',
        'availableuntil',
        'landlordid',
        'application_type',
        // 'studentid',
        // 'propertyid',

    ];
}
