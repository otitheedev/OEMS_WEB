<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class otherBenifitsbyPercentage extends Model
{
        #use HasFactory;
        protected $table='child_other_benifits_by_percentage';
        protected $fillable=[
            'other_benifits_name',
            'other_benifits_by_percentage',
            'user_id',
        ];
        
        public function reg_user()
     {
         return $this->belongsTo(reg_user::class);
     }
}
