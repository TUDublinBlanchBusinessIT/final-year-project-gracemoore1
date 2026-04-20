<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentReminder extends Model
{
    protected $table = 'rent_reminders';
    public $timestamps = false;

    protected $fillable = [
        'application_id',
        'group_id',
        'month',
        'year',
        'type',
        'amount',
        'for_date',
        'triggered_at',
    ];
}