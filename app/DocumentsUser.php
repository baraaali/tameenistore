<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentsUser extends Model
{
     protected $table='documents_users';
     protected $fillable=['license_image','start_date','end_date','id_image','company_name'
         ,'license_number','user_id'];

     public function User()
    {
    	return $this->belongsTo('\App\User','user_id','id');
    }
}
