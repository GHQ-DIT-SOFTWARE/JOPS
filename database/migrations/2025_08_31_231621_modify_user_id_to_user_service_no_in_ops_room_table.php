<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyUserIdToUserServiceNoInOpsRoomTable extends Migration
{
    public function up()
    {
        Schema::table('ops_room', function (Blueprint $table) {
            // Drop foreign key constraint on user_id
            $table->dropForeign('ops_room_user_id_foreign');

            // Rename user_id to user_service_no
            $table->renameColumn('user_id', 'user_service_no');
        });

        // Change column type and add foreign key in separate step
        Schema::table('ops_room', function (Blueprint $table) {
            // Change column type to string(50)
            $table->string('user_service_no', 50)->change();

            // Add foreign key constraint referencing users.service_no
            $table->foreign('user_service_no', 'ops_room_user_service_no_foreign')
                ->references('service_no')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('ops_room', function (Blueprint $table) {
            // Drop foreign key on user_service_no
            $table->dropForeign('ops_room_user_service_no_foreign');
        });

        Schema::table('ops_room', function (Blueprint $table) {
            // Rename user_service_no back to user_id
            $table->renameColumn('user_service_no', 'user_id');
        });

        Schema::table('ops_room', function (Blueprint $table) {
            // Change column type back to unsignedBigInteger
            $table->unsignedBigInteger('user_id')->change();

            // Add foreign key constraint referencing users.id
            $table->foreign('user_id', 'ops_room_user_id_foreign')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }
}
