<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hobbies extends Model
{
    #use HasFactory;
    protected $table='child_hobbies';
    protected $fillable=[
        'hobbies',
        'user_id',
    ];

    public function reg_user()
    {
        return $this->belongsTo(reg_user::class);
    }
}
