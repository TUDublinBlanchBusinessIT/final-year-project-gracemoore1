<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 1) Rename studentgrouping -> groups
        if (Schema::hasTable('studentgrouping')) {
            Schema::rename('studentgrouping', 'groups');
        }

        // 2) Add/adjust columns on groups
        Schema::table('groups', function (Blueprint $table) {
            // Add created_by (FK to student.id) and optional display name if missing
            if (!Schema::hasColumn('groups', 'created_by')) {
                $table->unsignedBigInteger('created_by')->nullable()->after('id');
            }
            if (!Schema::hasColumn('groups', 'name')) {
                $table->string('name')->nullable()->after('created_by');
            }

            // Existing columns: status, dateapplied, created_at, updated_at stay as-is

            // Add FK to student (nullable on delete)
            $table->foreign('created_by')->references('id')->on('student')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('groups', function (Blueprint $table) {
            if (Schema::hasColumn('groups', 'created_by')) {
                $table->dropForeign(['created_by']);
                $table->dropColumn('created_by');
            }
            if (Schema::hasColumn('groups', 'name')) {
                $table->dropColumn('name');
            }
        });

        if (Schema::hasTable('groups')) {
            Schema::rename('groups', 'studentgrouping');
        }
    }
};
