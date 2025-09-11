<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('duty_officer_accounts', function (Blueprint $table) {
            $table->string('show_temp_password', 50)->nullable()->after('temp_password_hash');
        });
    }

    public function down(): void
    {
        Schema::table('duty_officer_accounts', function (Blueprint $table) {
            $table->dropColumn('show_temp_password');
        });
    }
};