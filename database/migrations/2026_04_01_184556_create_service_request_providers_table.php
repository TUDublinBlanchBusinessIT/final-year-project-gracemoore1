<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('servicerequestprovider', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('servicerequestid');
            $table->unsignedBigInteger('serviceproviderpartnershipid');
            $table->enum('status', ['pending', 'accepted', 'declined', 'closed'])->default('pending');
            $table->timestamp('responded_at')->nullable();
            $table->timestamps();

            $table->unique(
                ['servicerequestid', 'serviceproviderpartnershipid'],
                'sr_provider_unique'
            );

            $table->index('servicerequestid');
            $table->index('serviceproviderpartnershipid');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('servicerequestprovider');
    }
};