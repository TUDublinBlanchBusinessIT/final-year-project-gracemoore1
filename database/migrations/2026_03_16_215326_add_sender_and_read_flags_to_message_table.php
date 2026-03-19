<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('message', function (Blueprint $table) {
            $table->string('sender_type')->nullable()->after('content');
            $table->boolean('is_read_by_student')->default(false)->after('sender_type');
            $table->boolean('is_read_by_landlord')->default(false)->after('is_read_by_student');
        });

        DB::table('message')
            ->whereNull('sender_type')
            ->update([
                'sender_type' => 'landlord',
                'is_read_by_student' => false,
                'is_read_by_landlord' => true,
            ]);
    }

    public function down(): void
    {
        Schema::table('message', function (Blueprint $table) {
            $table->dropColumn([
                'sender_type',
                'is_read_by_student',
                'is_read_by_landlord',
            ]);
        });
    }
};