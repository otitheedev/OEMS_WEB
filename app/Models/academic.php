<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class academic extends Model
{
    #use HasFactory;
    protected $table='child_academic';
    protected $fillable=[
        'degree_information',
        'degree',
        'join_year',
        'pass_year',
        'user_id',     
    ];

    public function reg_user()
    {
        return $this->belongsTo(reg_user::class);
    }

}
