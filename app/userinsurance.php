<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class userinsurance extends Model
{
    protected $table = 'userinsurance';
    protected $primaryKey = 'id';
     use SoftDeletes;
     
       public function insurnace()
    {
        return $this->hasOne('\App\Insurance','id','insurance_id');
    }
    
    public function user()
    {
      return $this->hasOne('App\user','id','user_id');
    }
    
    public function model(){
        return $this->hasOne('\App\models','id','model_id');
    }
    public function brand(){
        return $this->hasOne('\App\brands','id','brand_id');
    }

}