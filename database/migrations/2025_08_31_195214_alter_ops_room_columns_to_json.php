<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ops_room', function (Blueprint $table) {
            $table->json('major_event')->nullable()->change();
            $table->json('sitrep_army_sig_event')->nullable()->change();
            $table->json('sitrep_navy_sig_event')->nullable()->change();
            $table->json('sitrep_airforce_sig_event')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('ops_room', function (Blueprint $table) {
            $table->text('major_event')->nullable()->change();
            $table->text('sitrep_army_sig_event')->nullable()->change();
            $table->text('sitrep_navy_sig_event')->nullable()->change();
            $table->text('sitrep_airforce_sig_event')->nullable()->change();
        });
    }
};
