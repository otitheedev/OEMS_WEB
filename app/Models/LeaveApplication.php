<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveApplication extends Model
{
    use HasFactory;

    protected $casts = [
        'application_start_date' => 'datetime',
        'application_end_date' => 'datetime',
    ];

    protected $table='leave_application';
    protected $fillable = ['user_id', 'application_type', 'application_message','application_start_date','application_end_date','status','view'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
