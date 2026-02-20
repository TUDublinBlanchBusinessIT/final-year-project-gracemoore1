<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceProviderPartnership extends Model
{
    protected $table = 'serviceproviderpartnership'; // or your exact table name

    public $timestamps = false;

    protected $fillable = [
        'servicetype',
        'firstname',
        'surname',
        'companyname',
        'email',
        'phone',
        'county',
        'password',
        'commissionperjob',
        'feepermonth',
        'administratorid'
    ];
}
