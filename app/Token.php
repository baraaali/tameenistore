<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $table = 'tokens';
    protected $fillable = ['user_id' , 'token'];
    protected $hidden=['created_at','updated_at'];

    public function User(){
        return $this->belongsTo('\App\User','user_id','id');
    }

}
