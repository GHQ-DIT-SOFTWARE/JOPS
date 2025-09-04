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
    Schema::table('ops_room', function (Blueprint $table) {
        $table->string('status')->default('pending_dland'); // default when submitted
    });
}

public function down(): void
{
    Schema::table('ops_room', function (Blueprint $table) {
        $table->dropColumn('status');
    });
}

};
