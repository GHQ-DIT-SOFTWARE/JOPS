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
    Schema::table('activity_logs', function (Blueprint $table) {
        if (!Schema::hasColumn('activity_logs', 'service_no')) {
            $table->string('service_no')->nullable()->after('uuid');
        }
    });
}

public function down(): void
{
    Schema::table('activity_logs', function (Blueprint $table) {
        if (Schema::hasColumn('activity_logs', 'service_no')) {
            $table->dropColumn('service_no');
        }
    });
}

};
