<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('serviceproviderpartnership', function (Blueprint $table) {
            $table->string('firstname')->after('servicetype');
            $table->string('surname')->after('firstname');
            $table->string('county')->after('phone');
            $table->string('password')->after('county'); // stores hashed password
        });
    }

    public function down(): void
    {
        Schema::table('serviceproviderpartnership', function (Blueprint $table) {
            $table->dropColumn(['firstname', 'surname', 'county', 'password']);
        });
    }
};