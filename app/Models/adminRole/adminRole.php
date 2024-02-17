<?php

namespace App\Models\adminRole;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class adminRole extends Model
{
   #use HasFactory;
   protected $table='roles';
   protected $fillable=[
       'name',
   ];
}
