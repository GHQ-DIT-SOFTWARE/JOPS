<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyStatusColumnNullableInOpsRoomTable extends Migration
{
    public function up()
    {
        Schema::table('ops_room', function (Blueprint $table) {
            // Make status nullable and remove default
            $table->string('status')->nullable()->default(null)->change();
        });
    }

    public function down()
    {
        Schema::table('ops_room', function (Blueprint $table) {
            // Revert back to NOT NULL with previous default if needed
            $table->string('status')->default('pending_dland')->change();
        });
    }
}
