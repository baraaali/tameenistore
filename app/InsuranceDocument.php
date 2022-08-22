<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InsuranceDocument extends Model
{
    protected $table = 'insurance_document';
    protected $fillable=['insurance_id','user_id','country_id','other_id','brand_id','model_id','ar_term','en_term','year',
        'specific_year','firstinterval','secondinterval','thirdinterval','Insurance_Company_ar','Insurance_Company_en'
        ,'Insurance_Company_en','logo','deliveryFee','precent','discount_q','start_disc','end_disc','type',
        'type_of_use','in_duration','price','status','end_date'];

     use SoftDeletes;
       public function insurnace()
    {
        return $this->hasOne('\App\Insurance','id','insurance_id');
    }
      public function User()
    {
        return $this->hasOne('\App\User','id','user_id');
    }
    public function idbrand()
        {
        return $this->hasOne('App\brands','id','brand_id');
        }
     public function idmodel()
        {
        return $this->hasOne('App\models','id','model_id');
        }
}
