<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups_table';

    protected $fillable = [
        'name', 'created_by', 'status', 'dateapplied',
    ];

    public function creator()
    {
        return $this->belongsTo(Student::class, 'created_by');
    }

    public function members()
    {
        // student_groups(group_id, student_id)
        return $this->belongsToMany(Student::class, 'student_groups', 'group_id', 'student_id')
                    ->withPivot(['role'])
                    ->withTimestamps();
    }

    // Applications stored in the same application table (group rows only)
    public function applications()
    {
        return $this->hasMany(\App\Models\Application::class, 'group_id');
    }
}