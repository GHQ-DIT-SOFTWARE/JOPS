<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the old text column
            if (Schema::hasColumn('users', 'unit')) {
                $table->dropColumn('unit');
            }

            // Add the new unit_id column
            $table->unsignedBigInteger('unit_id')->nullable()->after('rank');

            // Add foreign key constraint
            $table->foreign('unit_id')
                  ->references('id')
                  ->on('units')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Remove foreign key and column
            $table->dropForeign(['unit_id']);
            $table->dropColumn('unit_id');

            // Restore the old column
            $table->string('unit')->nullable()->after('rank');
        });
    }
};
