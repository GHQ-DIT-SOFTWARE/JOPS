<?php
// database/migrations/XXXX_XX_XX_XXXXXX_add_temp_password_to_duty_officer_accounts_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('duty_officer_accounts', function (Blueprint $table) {
            $table->string('temp_password')->nullable()->after('account_created_at');
        });
    }

    public function down(): void
    {
        Schema::table('duty_officer_accounts', function (Blueprint $table) {
            $table->dropColumn('temp_password');
        });
    }
};