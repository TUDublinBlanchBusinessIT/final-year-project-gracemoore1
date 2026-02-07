<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\DB;

class MarkLandlordVerified
{
    public function handle(Verified $event): void
    {
        DB::table('landlord')
            ->where('email', $event->user->email)
            ->update(['verified' => 1]);
    }
}
