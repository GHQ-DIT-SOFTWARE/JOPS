<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        if (!Schema::hasColumn('users', 'service_no')) {
            $table->string('service_no')->unique()->after('id');
        }
        if (!Schema::hasColumn('users', 'rank')) {
            $table->string('rank')->nullable()->after('service_no');
        }
        if (!Schema::hasColumn('users', 'fname')) {
            $table->string('fname')->after('rank');
        }
        if (!Schema::hasColumn('users', 'unit')) {
            $table->string('unit')->nullable()->after('fname');
        }
        if (!Schema::hasColumn('users', 'phone')) {
            $table->string('phone')->nullable()->after('unit');
        }
        if (!Schema::hasColumn('users', 'arm_of_service')) {
            $table->string('arm_of_service')->nullable()->after('phone');
        }
        if (!Schema::hasColumn('users', 'gender')) {
            $table->enum('gender', ['Male', 'Female'])->nullable()->after('password');
        }
        if (!Schema::hasColumn('users', 'is_role')) {
            $table->tinyInteger('is_role')->default(0)->after('gender');
        }

        // Just make email nullable without re-adding unique constraint
        if (Schema::hasColumn('users', 'email')) {
            $table->string('email')->nullable()->change();
        }
    });
}


    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the added columns
            $table->dropColumn(['service_no', 'rank', 'fname', 'unit', 'phone', 'arm_of_service', 'gender', 'is_role']);
        });
    }
};
