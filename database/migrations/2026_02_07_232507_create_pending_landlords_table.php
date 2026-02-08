<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('pending_landlords', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 50);
            $table->string('surname', 50);
            $table->string('email', 100)->unique();
            $table->string('phone', 20);
            $table->string('password'); // hashed
            $table->string('verification_code', 10);
            $table->timestamp('code_expires_at');
            $table->boolean('ocr_verified')->default(false);
            $table->boolean('email_verified')->default(false);
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pending_landlords');
    }
};
