<?php
// database/migrations/XXXX_XX_XX_XXXXXX_create_available_duty_officers_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('available_duty_officers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('duty_month');
            $table->boolean('is_available')->default(true);
            $table->text('notes')->nullable();
            $table->foreignId('added_by')->constrained('users');
            $table->timestamps();
            
            $table->unique(['user_id', 'duty_month']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('available_duty_officers');
    }
};