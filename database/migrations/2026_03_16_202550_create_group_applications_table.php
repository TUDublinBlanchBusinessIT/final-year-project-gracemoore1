<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('group_applications', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('group_id');
            $table->unsignedBigInteger('listing_id');   // references rental.id
            $table->unsignedBigInteger('created_by');   // student who initiated
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');

            // Stores the ad-hoc tenant details you currently capture (keeps UX parity)
            $table->json('members_meta')->nullable();   // e.g. [{full_name,email,age,gender}, ...]
            $table->text('additional_details')->nullable();

            $table->dateTime('dateapplied')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();

            // Prevent the same group applying to the same listing twice
            $table->unique(['group_id', 'listing_id'], 'uq_group_listing');

            // FKs
            $table->foreign('group_id')->references('id')->on('groups')->cascadeOnDelete();
            $table->foreign('listing_id')->references('id')->on('rental');   // your table is 'rental'
            $table->foreign('created_by')->references('id')->on('student');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('group_applications');
    }
};