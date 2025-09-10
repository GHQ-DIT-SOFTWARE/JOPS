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
    Schema::table('duty_officer_accounts', function (Blueprint $table) {
        $table->dropColumn('temp_password');
    });
}

public function down()
{
    Schema::table('duty_officer_accounts', function (Blueprint $table) {
        $table->string('temp_password')->nullable()->after('account_created_at');
    });
}
};
