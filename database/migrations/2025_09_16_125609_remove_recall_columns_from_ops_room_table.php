<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('ops_room', function (Blueprint $table) {
        $table->dropColumn(['recall_until', 'scheduled_submit_at']);
    });
}

public function down()
{
    Schema::table('ops_room', function (Blueprint $table) {
        $table->dateTime('recall_until')->nullable();
        $table->dateTime('scheduled_submit_at')->nullable();
    });
}

};
