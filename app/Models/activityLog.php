<?php
declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory, UuidTrait;

    protected $fillable = [
        'user_id',           // User who performed the action
        'service_no',        // Service number of the user
        'name',              // Name of the user
        'action',            // Action performed (created, updated, deleted, submitted, published, replaced)
        'model_type',        // Model class (DutyRoster, User, etc.)
        'model_id',          // ID of the affected model
        'description',       // Detailed description of the action
        'details',           // Additional details (JSON format)
        'date_time',         // When the action occurred
        'ip_address',        // IP address of the user
    ];

    protected $casts = [
        'date_time' => 'datetime',
        'details' => 'array',
    ];

    /**
     * Relationship to the user who performed the action
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship to the affected model (polymorphic)
     */
    public function model()
    {
        return $this->morphTo();
    }

    /**
     * Scope for duty roster related activities
     */
    public function scopeDutyRoster($query)
    {
        return $query->where('model_type', DutyRoster::class);
    }

    /**
     * Scope for replacement activities
     */
    public function scopeReplacements($query)
    {
        return $query->where('action', 'replaced');
    }

    /**
     * Scope for activities by specific user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope for activities within date range
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('date_time', [$startDate, $endDate]);
    }
}