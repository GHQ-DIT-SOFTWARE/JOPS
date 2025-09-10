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
        // database/migrations/XXXX_XX_XX_XXXXXX_create_duty_rosters_table.php
Schema::create('duty_rosters', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->date('duty_date');
    $table->boolean('is_extra')->default(false);
    $table->timestamps();
    
    $table->unique(['user_id', 'duty_date']); // One officer per day
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('duty_rosters');
    }
};
