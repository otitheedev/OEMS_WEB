<?php

namespace App\Models\adminRole;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class adminUserRole extends Model
{
   #use HasFactory;
   public $timestamps = false;
   protected $table='role_user';
   protected $fillable=[
       'user_id',
       'role_id',
   ];
}