<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $fillable = [
        'role',
        'category',
        'question',
        'answer',
        'keywords',
        'is_active',
    ];
}