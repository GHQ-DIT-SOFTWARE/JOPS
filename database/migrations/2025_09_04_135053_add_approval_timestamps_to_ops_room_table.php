<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('ops_room', function (Blueprint $table) {
            // Add DLAND and DG approval timestamps
            $table->timestamp('dland_approved_at')->nullable()->after('dg_remarks');
            $table->timestamp('dg_approved_at')->nullable()->after('dland_approved_at');
        });
    }

    public function down(): void
    {
        Schema::table('ops_room', function (Blueprint $table) {
            $table->dropColumn(['dland_approved_at', 'dg_approved_at']);
        });
    }
};
