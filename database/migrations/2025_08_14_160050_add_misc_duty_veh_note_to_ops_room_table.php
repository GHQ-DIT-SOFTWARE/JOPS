<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('ops_room', function (Blueprint $table) {
            $table->longText('misc_duty_veh_note')->nullable()->after('sitrep_airforce_sy_gen');
        });
    }

    public function down()
    {
        Schema::table('ops_room', function (Blueprint $table) {
            $table->dropColumn('misc_duty_veh_note');
        });
    }
};

