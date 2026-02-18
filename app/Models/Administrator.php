<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Administrator extends Model
{
    protected $table = 'administrator';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'id', 'id');
    }
}
