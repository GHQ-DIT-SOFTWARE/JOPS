<?php

declare(strict_types=1);
namespace App\Models;

use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpsRoom extends Model
{
    use HasFactory;
    use UuidTrait;

    protected $table = 'ops_room';

    protected $fillable = [
        'user_id',
        'reporting_time',
        'gen_sy_gen',
        'gen_sig_event',
        'ops_room_comm_state',
        'ops_room_messages',
        'visit_ops_room',
        'sitrep_camp_sy_gen',
        'sitrep_camp_main_gate',
        'sitrep_camp_command_gate',
        'sitrep_camp_congo_junction',
        'sitrep_camp_gafto',
        'major_event',
        'sitrep_army_sy_gen',
        'sitrep_army_sig_event',
        'sitrep_navy_sig_event',
        'sitrep_navy_sy_gen',
        'sitrep_airforce_sig_event',
        'sitrep_airforce_sy_gen',
        'misc_duty_veh_note',
        'misc_duty_veh_taking_over',
        'misc_duty_veh_handing_over',
        'major_news_of_military',
        'admin_gen_lighting',
        'admin_gen_feeding',
        'admin_gen_welfare',
        'ghq_office_keys',
        'gaf_fire_station',
        'photocopier_taking_over',
        'photocopier_handing_over',
        'additional_information',
        'd_land_ops_comment',
        'dg_remarks'
    ];

    protected $casts = [
        'reporting_time' => 'datetime',
        'gen_sy_gen' => 'array',
        'gen_sig_event' => 'array',
        'ops_room_comm_state' => 'array',
        'ops_room_messages' => 'array',
        'visit_ops_room' => 'array',
        'sitrep_army_sig_event' => 'array',
        'sitrep_navy_sig_event' => 'array',
        'sitrep_airforce_sig_event' => 'array',
        'misc_duty_veh_taking_over' => 'integer',
        'misc_duty_veh_handing_over' => 'integer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
