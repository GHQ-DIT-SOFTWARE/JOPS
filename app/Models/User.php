<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
        'rank',
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

}

