<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class holiday extends Model
{
    protected $table='holiday_event';
    protected $fillable = [
        'holiday_type',
        'holiday_title',
        'holiday_message',
        'holiday_file',
        'status',
        'view',
        'start_date',
        'end_date',
    ];

   protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ]; 
}
