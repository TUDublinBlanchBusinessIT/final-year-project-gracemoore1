<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceProviderPartnership extends Model
{
    protected $table = 'serviceproviderpartnership'; 
    protected $guarded = [];

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

    public function serviceRequestNotifications()
    {
        return $this->hasMany(ServiceRequestProvider::class, 'serviceproviderpartnershipid');
    }

}
