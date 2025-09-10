<?php
// database/migrations/XXXX_XX_XX_XXXXXX_add_status_to_duty_rosters_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('duty_rosters', function (Blueprint $table) {
            $table->enum('status', ['draft', 'submitted', 'published'])->default('draft')->after('is_extra');
            $table->timestamp('submitted_at')->nullable()->after('status');
            $table->timestamp('published_at')->nullable()->after('submitted_at');
            $table->foreignId('submitted_by')->nullable()->constrained('users')->after('submitted_at');
            $table->foreignId('published_by')->nullable()->constrained('users')->after('published_at');
        });
    }

    public function down(): void
    {
        Schema::table('duty_rosters', function (Blueprint $table) {
            $table->dropColumn(['status', 'submitted_at', 'published_at', 'submitted_by', 'published_by']);
        });
    }
};