<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberInsurance extends Model
{
    protected $table = 'memberships_insurance';
    protected $fillable = ['name_ar','name_en','price', 'type' , 'duration', 'free'];
    protected $hidden=['created_at','updated_at'];
    public function subscription(){
        return $this->hasMany('\App\SubscriptionUser','member_id','id');
    }

}
