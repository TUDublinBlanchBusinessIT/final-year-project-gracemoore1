<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendingLandlord extends Model
{
    protected $table = 'pending_landlords';

    protected $fillable = [
        'first_name',
        'surname',
        'email',
        'phone',
        'password',
        'verification_code',
        'code_expires_at',
        'ocr_verified',
        'email_verified',
    ];
}
