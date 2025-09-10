<?php

declare(strict_types=1);

namespace App\Models;



use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Rank extends Model
{
    use HasFactory;
  
 

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'rank_code',
        'army_display',
        'army_full',
        'navy_display',
        'navy_full',
        'airforce_display',
        'airforce_full',
        'category',

        'personnel_age_retirement',
        'personnel_years_in_rank',

        'officer_age_retirement_male',
        'officer_age_retirement_female',
        'officer_age_retirement_male_med',
        'officer_age_retirement_female_med',
        'officer_age_retirement_med_specialist',
        'officer_age_retirement_male_female_legal',

    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];

    public function personnel()
    {
        return $this->hasMany(Personnel::class, 'present_rank', 'rank_code');
    }

    protected $appends = [
        'rank_name',
    ];

   public function getDisplayForService($armOfService)
{
    $arm = strtolower(str_replace(' ', '', $armOfService));

    if (in_array($arm, ['navy', 'nv'])) {
        return $this->navy_display ?? '-';
    }

    if (in_array($arm, ['airforce', 'air', 'af'])) {
        return $this->airforce_display ?? '-';
    }

    // Default to army
    return $this->army_display ?? '-';
}


public function getRankNameAttribute()
{
    return $this->army_display 
        ?? $this->navy_display 
        ?? $this->airforce_display 
        ?? '-';
}



}
