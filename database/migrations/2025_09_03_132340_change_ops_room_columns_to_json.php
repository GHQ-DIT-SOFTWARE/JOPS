<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ops_room', function (Blueprint $table) {
            $table->json('gen_sig_events')->nullable()->change();
            $table->json('ops_room_messages')->nullable()->change();
            $table->json('visit_ops_room')->nullable()->change();
            $table->json('major_event')->nullable()->change();
            $table->json('sitrep_army_sig_event')->nullable()->change();
            $table->json('sitrep_navy_sig_event')->nullable()->change();
            $table->json('sitrep_airforce_sig_event')->nullable()->change();
            $table->json('major_news_of_military')->nullable()->change();
            $table->json('ghq_office_keys')->nullable()->change();
            $table->json('gaf_fire_station')->nullable()->change();
            $table->json('additional_information')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('ops_room', function (Blueprint $table) {
            // Revert back to text/longText (depends on your original type)
            $table->longText('gen_sig_events')->nullable()->change();
            $table->longText('ops_room_messages')->nullable()->change();
            $table->longText('visit_ops_room')->nullable()->change();
            $table->longText('major_event')->nullable()->change();
            $table->longText('sitrep_army_sig_event')->nullable()->change();
            $table->longText('sitrep_navy_sig_event')->nullable()->change();
            $table->longText('sitrep_airforce_sig_event')->nullable()->change();
            $table->longText('major_news_of_military')->nullable()->change();
            $table->longText('ghq_office_keys')->nullable()->change();
            $table->longText('gaf_fire_station')->nullable()->change();
            $table->longText('additional_information')->nullable()->change();
        });
    }
};
