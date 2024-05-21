<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersChildInfo extends Model
{
       #use HasFactory;
       protected $table='child_users_childinfo';
       protected $fillable=[
           'child_name',
           'child_gender',
           'child_birthday',
           'user_id',     
       ];
   
       public function reg_user()
       {
           return $this->belongsTo(reg_user::class, 'user_id', 'id');
       }
}
