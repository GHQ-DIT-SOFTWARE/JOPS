<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpsRoom extends Model
{
    use HasFactory;

    protected $table = 'ops_room';

    protected $fillable = [
        'user_service_no',
        'reporting_time',
        'period_covered',
        'gen_sy_gen',
        'gen_sig_events',
        'ops_room_comm_state',
        'ops_room_messages',
        'visit_ops_room',
        'photocopier_taking_over',
        'photocopier_handing_over',
        'sitrep_camp_sy_gen',
        'sitrep_camp_main_gate',
        'sitrep_camp_command_gate',
        'sitrep_camp_congo_junction',
        'sitrep_camp_gafto',
        'major_event',
        'sitrep_army_sy_gen',
        'sitrep_army_sig_event',
        'sitrep_navy_sy_gen',
        'sitrep_navy_sig_event',
        'sitrep_airforce_sy_gen',
        'sitrep_airforce_sig_event',
        'misc_duty_veh_note',
        'misc_duty_veh_taking_over',
        'misc_duty_veh_handing_over',
        'major_news_of_military',
        'admin_gen_lighting',
        'admin_gen_feeding',
        'admin_gen_welfare',
        'ghq_office_keys',
        'gaf_fire_station',
        'additional_information',
        'd_land_ops_comment',
        'dg_remarks',
    ];

    // Remove $casts array entirely or empty it
    protected $casts = [
        // none
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_service_no', 'service_no');
    }
}


