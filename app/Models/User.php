<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Define role constants
    public const ROLE_SUPERADMIN = 0;
    public const ROLE_DG = 1;
    public const ROLE_DLAND = 2;
    public const ROLE_DADMIN = 3;
    public const ROLE_DOFFR = 4;
    public const ROLE_DCLERK = 5;
    public const ROLE_DWO = 6;
    public const ROLE_DDRIVER = 7;
    public const ROLE_DRADIO = 8;

    // Map role IDs to names
    public static $roleNames = [
        self::ROLE_SUPERADMIN => 'Superadmin',
        self::ROLE_DG => 'DG',
        self::ROLE_DLAND => 'DLand',
        self::ROLE_DADMIN => 'Dadmin',
        self::ROLE_DOFFR => 'Doffr',
        self::ROLE_DCLERK => 'Dclerk',
        self::ROLE_DWO => 'Dwo',
        self::ROLE_DDRIVER => 'Ddriver',
        self::ROLE_DRADIO => 'Dradio',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'service_no',
        'rank_code',
        'fname',
        'unit_id',
        'phone',
        'arm_of_service',
        'email',
        'password',
        'gender',
        'is_role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the human-readable role name.
     *
     * @return string
     */
    public function roleName(): string
    {
        return self::$roleNames[$this->is_role] ?? 'Unknown';
    }

    /**
     * Check if user has a specific role.
     *
     * @param int $role
     * @return bool
     */
    public function hasRole(int $role): bool
    {
        return $this->is_role === $role;
    }

    /**
     * Check if user has any of the given roles.
     *
     * @param array $roles
     * @return bool
     */
    public function hasAnyRole(array $roles): bool
    {
        return in_array($this->is_role, $roles);
    }

    /**
     * Override the method to use service_no for authentication.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'service_no';
    }

    public function getRoleNameAttribute(): string
{
    return self::$roleNames[$this->is_role] ?? 'Unknown';
}


public function opsRooms()
{
    return $this->hasMany(OpsRoom::class);
}

public function unit()
{
    return $this->belongsTo(Unit::class, 'unit_id');
}


public function dutyRosters()
    {
        return $this->hasMany(DutyRoster::class);
    }

    public function dutyOfficerAccounts()
    {
        return $this->hasMany(DutyOfficerAccount::class);
    }
    
    public function canAccessDutyRoster()
    {
        return in_array($this->is_role, [
            self::ROLE_SUPERADMIN,
            self::ROLE_DG,
            self::ROLE_DLAND,
            self::ROLE_DADMIN,
            self::ROLE_DOFFR,
            self::ROLE_DCLERK
        ]);
    }
    
    public function canManageDutyRoster()
    {
        return in_array($this->is_role, [
            self::ROLE_SUPERADMIN,
            self::ROLE_DG,
            self::ROLE_DLAND,
            self::ROLE_DADMIN
        ]);
    }
    
    public function canCreateAccounts()
    {
        return in_array($this->is_role, [
            self::ROLE_SUPERADMIN,
            self::ROLE_DCLERK
        ]);
    }
    
    public function isDutyOfficer()
    {
        return in_array($this->is_role, [
            self::ROLE_DOFFR,
            self::ROLE_DCLERK,
            self::ROLE_DWO,
            self::ROLE_DDRIVER,
            self::ROLE_DRADIO
        ]);
    }

    public function rank()
{
    return $this->belongsTo(Rank::class, 'rank_code', 'rank_code');
}

//     public function getDisplayRankAttribute()
// {
//     if ($this->rank) {
//         return $this->rank->getDisplayForService($this->arm_of_service);
//     }

//     return $this->rank_code;
// }

public function getFullRankAttribute()
{
    if ($this->rank) {
        $arm = strtolower(str_replace(' ', '', $this->arm_of_service));

        if (in_array($arm, ['navy', 'nv'])) {
            return $this->rank->navy_full ?? $this->rank->navy_display ?? $this->rank_code;
        }

        if (in_array($arm, ['airforce', 'air', 'af'])) {
            return $this->rank->airforce_full ?? $this->rank->airforce_display ?? $this->rank_code;
        }

        return $this->rank->army_full ?? $this->rank->army_display ?? $this->rank_code;
    }

    return $this->rank_code;
}


// In your User model
public function rankInfo()
{
    return $this->belongsTo(Rank::class, 'rank_code', 'rank_code');
}

// In your User model
public function getDisplayRankAttribute()
{
    if ($this->rankInfo) { // ✅ Changed from $this->rank
        return $this->rankInfo->getDisplayForService($this->arm_of_service);
    }
    return $this->rank; // This will return the database column value
}

  

    /**
     * Get account status for a specific month and year
     * Returns: 'created', 'needed', or 'none'
     */
    public function getAccountStatusForMonth($month, $year)
    {
        // Assuming you have a DutyOfficerAccount model that tracks account status
        // Adjust this based on your actual database structure
        
        $dutyMonth = Carbon::createFromDate($year, $month, 1)->format('Y-m-01');
        
        // Check if this user has an account record for the specified month
        $account = DutyOfficerAccount::where('user_id', $this->id)
                    ->where('duty_month', $dutyMonth)
                    ->first();
        
        if ($account) {
            if ($account->account_created) {
                return 'created';
            } elseif ($account->needs_account) {
                return 'needed';
            }
        }
        
        return 'none';
    }
// app/Models/User.php
public function isUsingTempPassword()
{
    return \App\Models\DutyOfficerAccount::where('user_id', $this->id)
        ->whereNotNull('show_temp_password')
        ->exists();
}

}

