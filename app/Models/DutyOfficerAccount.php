<?php
// app/Models/DutyOfficerAccount.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DutyOfficerAccount extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'duty_month', 'needs_account', 'account_created', 'created_by','temp_password_hash',
    'temp_password_expires_at','show_temp_password'];


    protected $casts = [

        'account_created' => 'boolean',         
    'needs_account' => 'boolean', 
    'account_created_at' => 'datetime',
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
    'temp_password_expires_at' => 'datetime',
];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}