<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('ops_room', function (Blueprint $table) {
        $table->string('period_covered')->nullable()->after('reporting_time');
    });
}

public function down()
{
    Schema::table('ops_room', function (Blueprint $table) {
        $table->dropColumn('period_covered');
    });
}

};
