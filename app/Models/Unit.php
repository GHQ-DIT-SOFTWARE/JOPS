<?php

declare(strict_types=1);

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Unit extends Model
{
    use HasFactory;
 

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'unit',
        'arm_of_service',
        'uuid',
        'attached_units',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // 'attached_units' => 'array'
    ];

    public function attached_units()
    {
        return $this->hasMany(AttachedUnit::class);
    }
}
