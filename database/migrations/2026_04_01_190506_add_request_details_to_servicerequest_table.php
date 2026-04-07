<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('servicerequest', function (Blueprint $table) {
            $table->string('address_housenumber')->nullable()->after('rentalid');
            $table->string('address_street')->nullable()->after('address_housenumber');
            $table->string('address_county')->nullable()->after('address_street');
            $table->string('address_postcode')->nullable()->after('address_county');
            $table->string('requestimage')->nullable()->after('address_postcode');
        });
    }

    public function down(): void
    {
        Schema::table('servicerequest', function (Blueprint $table) {
            $table->dropColumn([
                'address_housenumber',
                'address_street',
                'address_county',
                'address_postcode',
                'requestimage',
            ]);
        });
    }
};