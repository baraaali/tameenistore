<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model
{
    protected $table = 'payment_history';
    protected $fillable = ['user_id' , 'transaction','value','type','type_id','balance_after'];

    public function User(){
        return $this->belongsTo('\App\User','user_id','id');
    }

}
