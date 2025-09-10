<?php
// database/migrations/XXXX_XX_XX_XXXXXX_remove_available_duty_officers_foreign_key.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Remove the foreign key constraint
        Schema::table('available_duty_officers', function (Blueprint $table) {
            $table->dropForeign(['added_by']);
        });
    }

    public function down(): void
    {
        Schema::table('available_duty_officers', function (Blueprint $table) {
            $table->foreign('added_by')->references('id')->on('users')->onDelete('cascade');
        });
    }
};