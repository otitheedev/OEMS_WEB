<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class notice extends Model
{
    #use HasFactory;
    protected $table='notice';
    protected $fillable=[
        'notice_type',
        'notice_message',
        'status',
        'view',     
    ];

    public function reg_user()
    {
        return $this->belongsTo(reg_user::class);
    }
}
