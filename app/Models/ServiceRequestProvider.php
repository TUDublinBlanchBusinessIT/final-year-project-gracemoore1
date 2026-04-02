<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRequestProvider extends Model
{
    protected $table = 'servicerequestprovider';

    protected $fillable = [
        'servicerequestid',
        'serviceproviderpartnershipid',
        'status',
        'responded_at',
    ];

    public function serviceRequest()
    {
        return $this->belongsTo(ServiceRequest::class, 'servicerequestid');
    }


    public function provider()
    {
        return $this->belongsTo(ServiceProviderPartnership::class, 'serviceproviderpartnershipid');
    }
}