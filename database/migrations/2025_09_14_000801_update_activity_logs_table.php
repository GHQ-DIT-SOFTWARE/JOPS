<?php
declare(strict_types=1);
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_update_activity_logs_table.php
public function up()
{
    Schema::table('activity_logs', function (Blueprint $table) {
        $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
        $table->string('action')->nullable();
        $table->string('model_type')->nullable();
        $table->unsignedBigInteger('model_id')->nullable();
        $table->text('details')->nullable();
        $table->string('ip_address', 45)->nullable();
        
        // Add indexes
        $table->index(['model_type', 'model_id']);
        $table->index('action');
        $table->index('date_time');
    });
}

public function down()
{
    Schema::table('activity_logs', function (Blueprint $table) {
        $table->dropForeign(['user_id']);
        $table->dropColumn(['user_id', 'action', 'model_type', 'model_id', 'details', 'ip_address']);
    });
}
};
