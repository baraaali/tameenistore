<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    protected $table = 'balances';
    protected $fillable = ['user_id' , 'balance'];

    public function User(){
        return $this->belongsTo('\App\User','user_id','id');
    }
    
}
