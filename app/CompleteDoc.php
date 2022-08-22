<?php

namespace App;

use App\Vehicle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompleteDoc extends Model
{
    protected $table = 'complete_doc';

    protected $hidden=['created_at','updated_at','deleted_at'];

    protected $fillable=['insurance_id','user_id','type_of_use','model_id','brand_id','ar_term',
        'en_term','firstSlidePrice','OpenFileFirstSlide','OpenFilePerecentFirstSlide',
        'OpenFileMinimumFirstSlide','SecondSlidePrice','OpenFileSecondSlide','display','search_show',
        'OpenFilePerecentSecondSlide','thirdSlidePrice','OpenFileThirdSlide','OpenFilePerecentThirdSlide',
        'fourthSlidePrice','OpenFileFourthSlide','OpenFilePerecentFourthSlide','precent',
        'discount_q','start_disc','end_disc','price', 'status','end_date','deliveryFee','fake_discount',
        'Insurance_Company_ar','Insurance_Company_en','logo','year','in_duration','max_value','max_year',
        'max_year_search','country_id','vehicle_id'];
     use SoftDeletes;

     public function scopeSelectionExcpt($q){
         return $q->select('insurance_id','user_id','type_of_use','ar_term','en_term','precent',
       'discount_q','start_disc','end_disc','price', 'status','end_date','deliveryFee','Insurance_Company_ar'
       ,'Insurance_Company_en','logo','year','in_duration','max_value','max_year','max_year_search','country_id')->get();
     }
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

        public function conditions()
        {
            return $this->hasMany('App\Condition','insurance_document_id');
        }
        public function additions()
        {
            return $this->hasMany('App\Addition','insurance_document_id');
        }

        public function country(){
         return $this->belongsTo(country::class,'country_id','id');
        }
        public function vehicle()
        {
            return $this->belongsTo(Vehicle::class, 'vehicle_id');
        }

}
