<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Staff extends Authenticatable
{
    protected $table = 'staff';
    protected $primaryKey = 'id';
    public $timestamps = false; // unless you add timestamps to staff

    protected $fillable = [
        'firstname', 'surname', 'phonenumber', 'housenumber', 'street', 'county', 'postcode',
        'dateofbirth', 'dateofhire', 'employmenttype', 'bankiban', 'email','password'
    ];

    // If you want to check if this staff is an administrator:
    public function administrator()
    {
        return $this->hasOne(Administrator::class, 'id', 'id');
    }
}