// database/migrations/xxxx_xx_xx_create_duty_notifications_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('duty_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->string('type')->nullable(); // extra_duty, duty_replaced, etc.
            $table->date('related_date')->nullable();
            $table->date('duty_month'); // The month this notification relates to
            $table->timestamps();
            
            $table->index(['user_id', 'duty_month']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('duty_notifications');
    }
};