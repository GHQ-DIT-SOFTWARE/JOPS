<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('ops_room', function (Blueprint $table) {
            $table->string('d_land_signature')->nullable()->after('d_land_ops_comment');
            $table->string('dg_signature')->nullable()->after('d_land_signature');
        });
    }

    public function down(): void
    {
        Schema::table('ops_room', function (Blueprint $table) {
            $table->dropColumn(['d_land_signature', 'dg_signature']);
        });
    }
};
