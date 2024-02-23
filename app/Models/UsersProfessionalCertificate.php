<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersProfessionalCertificate extends Model
{
        #use HasFactory;
        protected $table='child_professional_certificate';
        protected $fillable=[
            'certificate_name',
            'organization_name',
            'start_date',
            'end_date', 
            'user_id',
        ];
        
        public function reg_user()
        {
            return $this->belongsTo(reg_user::class);
        }
}
