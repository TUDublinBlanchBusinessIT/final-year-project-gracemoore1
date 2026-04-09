<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $table = 'complaint'; // singular because your table is named "complaint"

    protected $fillable = [
        'subject',
        'description',
        'reporter_id',
        'administratorid',
        'reporter_role',
        'reported_user_id',
        'reported_user_role',
    ];

    public $timestamps = true; // complaint table has created_at/updated_at
}