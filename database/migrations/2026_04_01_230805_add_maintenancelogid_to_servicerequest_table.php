<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('servicerequest', function (Blueprint $table) {
            $table->unsignedBigInteger('maintenancelogid')->nullable()->after('rentalid');
            $table->index('maintenancelogid');
        });
    }

    public function down(): void
    {
        Schema::table('servicerequest', function (Blueprint $table) {
            $table->dropIndex(['maintenancelogid']);
            $table->dropColumn('maintenancelogid');
        });
    }
};