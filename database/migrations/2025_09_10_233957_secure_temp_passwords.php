<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('duty_officer_accounts', function (Blueprint $table) {
            // Remove the insecure plain text password column
            $table->dropColumn('temp_password');
            
            // Add secure hashed password column
            $table->string('temp_password_hash', 255)->nullable()->after('needs_account');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('duty_officer_accounts', function (Blueprint $table) {
            // Reverse the changes for rollback
            $table->string('temp_password', 50)->nullable()->after('needs_account');
            $table->dropColumn('temp_password_hash');
        });
    }
};