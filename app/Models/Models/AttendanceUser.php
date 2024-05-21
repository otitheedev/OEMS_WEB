<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceUser extends Model
{
    protected $table='attendance_users';
    protected $fillable = ['uid','userid', 'name', 'role', 'password', 'cardno'];
    
}
