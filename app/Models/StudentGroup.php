<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class StudentGroup extends Pivot
{
    protected $table = 'student_groups';
    public $timestamps = true;

    protected $fillable = ['group_id', 'student_id', 'role'];
}
