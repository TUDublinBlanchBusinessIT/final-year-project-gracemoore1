<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Rename table
        if (Schema::hasTable('studentgroupingleader')) {
            Schema::rename('studentgroupingleader', 'student_groups');
        }

        Schema::table('student_groups', function (Blueprint $table) {
            // Rename columns to canonical names if they exist
            if (Schema::hasColumn('student_groups', 'studentgroupingid') && !Schema::hasColumn('student_groups', 'group_id')) {
                $table->renameColumn('studentgroupingid', 'group_id');
            }
            if (Schema::hasColumn('student_groups', 'studentid') && !Schema::hasColumn('student_groups', 'student_id')) {
                $table->renameColumn('studentid', 'student_id');
            }

            // In case the types need to be unsigned bigints (to match your IDs)
            if (Schema::hasColumn('student_groups', 'group_id')) {
                $table->unsignedBigInteger('group_id')->change();
            }
            if (Schema::hasColumn('student_groups', 'student_id')) {
                $table->unsignedBigInteger('student_id')->change();
            }

            // Optional role column (leader/member)
            if (!Schema::hasColumn('student_groups', 'role')) {
                $table->string('role', 20)->nullable()->after('student_id');
            }

            // Indexes & uniqueness
            $table->index(['group_id', 'student_id'], 'idx_group_student');
            $table->unique(['group_id', 'student_id'], 'uq_group_student');

            // Foreign keys
            $table->foreign('group_id')->references('id')->on('groups')->cascadeOnDelete();
            $table->foreign('student_id')->references('id')->on('student')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('student_groups', function (Blueprint $table) {
            // drop FKs and indexes
            $table->dropForeign(['group_id']);
            $table->dropForeign(['student_id']);
            $table->dropUnique('uq_group_student');
            $table->dropIndex('idx_group_student');

            // drop role
            if (Schema::hasColumn('student_groups', 'role')) {
                $table->dropColumn('role');
            }

            // rename columns back (if you really need to rollback fully)
            if (Schema::hasColumn('student_groups', 'group_id')) {
                $table->renameColumn('group_id', 'studentgroupingid');
            }
            if (Schema::hasColumn('student_groups', 'student_id')) {
                $table->renameColumn('student_id', 'studentid');
            }
        });

        if (Schema::hasTable('student_groups')) {
            Schema::rename('student_groups', 'studentgroupingleader');
        }
    }
};
