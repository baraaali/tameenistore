<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubscriptionUser extends Model
{
    protected $table = 'subscription_users';
    protected $fillable = ['user_id' , 'member_id','end_date','type'];

    public function User(){
        return $this->belongsTo('\App\User','user_id','id');
    }
    public function membership(){
        return $this->belongsTo('\App\MemberInsurance','member_id','id');
    }
    public $timestamps = false;

}
