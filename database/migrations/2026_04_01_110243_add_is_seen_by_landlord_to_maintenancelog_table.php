<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('maintenancelog', function (Blueprint $table) {
            $table->boolean('is_seen_by_landlord')->default(false)->after('landlordid');
        });
    }

    public function down(): void
    {
        Schema::table('maintenancelog', function (Blueprint $table) {
            $table->dropColumn('is_seen_by_landlord');
        });
    }
};