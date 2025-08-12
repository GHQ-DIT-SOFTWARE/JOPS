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
        'service_no',   // added
        'name',
        'email',        // keep if you still want email logs, remove if not needed
        'description',
        'date_time',
    ];
}
