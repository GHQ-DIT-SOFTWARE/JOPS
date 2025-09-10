<?php
// database/migrations/XXXX_XX_XX_XXXXXX_create_duty_officer_accounts_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('duty_officer_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('duty_month');
            $table->boolean('needs_account')->default(false);
            $table->boolean('account_created')->default(false);
            $table->timestamp('account_created_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->timestamps();
            
            $table->unique(['user_id', 'duty_month']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('duty_officer_accounts');
    }
};