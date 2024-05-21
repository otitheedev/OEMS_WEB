<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    #use HasFactory;
    protected $table='attendances';
    protected $fillable = [
        'uid',
        'userid',
        'state',
        'timestamp',
        'type',
    ];


    public function user(){
        return $this->hasOne(AttendanceUser::class, 'uid', 'userid');
    }
    
}
