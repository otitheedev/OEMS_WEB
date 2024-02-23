<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class extra_benifits extends Model
{
    #use HasFactory;
    protected $table='child_extra_benifits';
    protected $fillable=[
        'benifits_name',
        'benifits_amount', 
        'user_id',
    ];

    public function reg_user()
    {
        return $this->belongsTo(reg_user::class);
    }
}
