<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('ops_room', function (Blueprint $table) {
            // Add indexes
            $table->index('user_id', 'idx_user_id');
            $table->index('reporting_time', 'idx_reporting_time');

            // Change columns to integers
            $table->integer('misc_duty_veh_taking_over')->change();
            $table->integer('misc_duty_veh_handing_over')->change();
        });
    }

    public function down()
    {
        Schema::table('ops_room', function (Blueprint $table) {
            // Remove indexes
            $table->dropIndex('idx_user_id');
            $table->dropIndex('idx_reporting_time');

            // Change back to original type (replace with the actual previous type)
            $table->string('misc_duty_veh_taking_over')->change();
            $table->string('misc_duty_veh_handing_over')->change();
        });
    }
};
