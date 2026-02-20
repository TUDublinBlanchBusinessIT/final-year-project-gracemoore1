<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_password_resets', function (Blueprint $table) {
            $table->id();
            $table->string('email')->index();
            $table->string('token', 64)->index();
            $table->timestamp('created_at')->nullable();
            // no updated_at needed for this table
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_password_resets');
    }
};
