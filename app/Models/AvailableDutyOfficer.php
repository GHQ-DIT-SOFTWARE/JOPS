<?php
// app/Models/AvailableDutyOfficer.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvailableDutyOfficer extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'duty_month', 'is_available', 'notes', 'added_by'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
}