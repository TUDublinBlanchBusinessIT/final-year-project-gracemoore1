<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // dateofbirth
        if (!Schema::hasColumn('student', 'dateofbirth')) {
            Schema::table('student', function (Blueprint $table) {
                $table->date('dateofbirth')->nullable()->after('surname');
            });
        }

        // email_verification_code
        if (!Schema::hasColumn('student', 'email_verification_code')) {
            Schema::table('student', function (Blueprint $table) {
                $table->string('email_verification_code', 10)->nullable()->after('password');
            });
        }

        // email_verified
        if (!Schema::hasColumn('student', 'email_verified')) {
            Schema::table('student', function (Blueprint $table) {
                $table->boolean('email_verified')->default(false)->after('email_verification_code');
            });
        }

        // timestamps
        if (!Schema::hasColumn('student', 'created_at') && !Schema::hasColumn('student', 'updated_at')) {
            Schema::table('student', function (Blueprint $table) {
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::table('student', function (Blueprint $table) {
            if (Schema::hasColumn('student', 'dateofbirth')) $table->dropColumn('dateofbirth');
            if (Schema::hasColumn('student', 'email_verification_code')) $table->dropColumn('email_verification_code');
            if (Schema::hasColumn('student', 'email_verified')) $table->dropColumn('email_verified');
            if (Schema::hasColumn('student', 'created_at') && Schema::hasColumn('student', 'updated_at')) {
                $table->dropTimestamps();
            }
        });
    }
};