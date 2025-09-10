<?php
// app/Models/DutyRoster.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DutyRoster extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'duty_date', 'is_extra', 'status'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'duty_date' => 'date',
        'is_extra' => 'boolean',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function submittedBy()
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }
    
    public function publishedBy()
    {
        return $this->belongsTo(User::class, 'published_by');
    }
}