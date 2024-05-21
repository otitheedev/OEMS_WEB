<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class medicalHistory extends Model
{
    #use HasFactory;
    protected $table='child_medical_history';
    protected $fillable=[
        'medical_history',
        'user_id',   
    ];

    public function reg_user()
    {
        return $this->belongsTo(reg_user::class);
    }
}
