<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/Student.php
class Student extends Model {
    protected $table = 'student';
    protected $fillable = [
        'firstname','surname','dateofbirth','email','password','email_verification_code','email_verified','id_verified'
    ];

    protected $hidden = ['password','email_code'];
}

