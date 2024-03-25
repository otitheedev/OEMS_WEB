<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobExpriences extends Model
{
     #use HasFactory;
     protected $table='child_jobexprieces';
     protected $fillable=[
         'job_designation_name',
         'job_org_name',
         'job_start_date',
         'job_end_date',
         'user_id',
     ];

     public function reg_user()
     {
         return $this->belongsTo(reg_user::class);
     }
}
