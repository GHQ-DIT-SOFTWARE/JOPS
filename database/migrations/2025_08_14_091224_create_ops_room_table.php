<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ops_room', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->timestamp('reporting_time')->nullable();

            // Array fields stored as JSON
            $table->json('gen_sy_gen')->nullable();
            $table->json('gen_sig_event')->nullable();
            $table->json('ops_room_comm_state')->nullable();
            $table->json('ops_room_messages')->nullable();
            $table->json('visit_ops_room')->nullable();

            // SITREP camp details
            $table->text('sitrep_camp_sy_gen')->nullable();
            $table->text('sitrep_camp_main_gate')->nullable();
            $table->text('sitrep_camp_command_gate')->nullable();
            $table->text('sitrep_camp_congo_junction')->nullable();
            $table->text('sitrep_camp_gafto')->nullable();

            
            // Major Event
            $table->text('major_event')->nullable();


            // Army
            $table->text('sitrep_army_sy_gen')->nullable();
            $table->text('sitrep_army_sig_event')->nullable();

            // Navy
            $table->text('sitrep_navy_sig_event')->nullable();
            $table->text('sitrep_navy_sy_gen')->nullable();

            // Airforce
            $table->text('sitrep_airforce_sig_event')->nullable();
            $table->text('sitrep_airforce_sy_gen')->nullable();

            // Miscellaneous
            $table->text('misc_duty_veh_taking_over')->nullable();
            $table->text('misc_duty_veh_handing_over')->nullable();
            $table->text('major_news_of_military')->nullable();
            $table->text('admin_gen_lighting')->nullable();
            $table->text('admin_gen_feeding')->nullable();
            $table->text('admin_gen_welfare')->nullable();
            $table->text('ghq_office_keys')->nullable();

            // GAF fire station (array)
            $table->json('gaf_fire_station')->nullable();

            // Photocopier details
            $table->text('photocopier_taking_over')->nullable();
            $table->text('photocopier_handing_over')->nullable();

            $table->text('additional_information')->nullable();
            $table->text('d_land_ops_comment')->nullable();
            $table->text('dg_remarks')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ops_room');
    }
};
