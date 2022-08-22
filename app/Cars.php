<?php

namespace App;

use App\User;
use App\brands;
use App\Vehicle;
use App\Governorate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cars extends Model
{
    use SoftDeletes;
    protected $table='cars';
  protected $fillable=['agent_id','category_id','en_name','ar_name','ar_model','en_model','ar_brand','year','country_id',
      'color','type_of_car','transmission','fuel','max','engine','kilo_meters','used','en_description','discount_percent',
      'ar_description','en_features','ar_features','talap','sell','end_date','special','visitors','status',
      'main_image','rent_type','end_ad_date'];

      

    public function getName($lang = null)
    {
        if($lang)
        {
          $name = $lang.'_name';
          return $this->$name;
        }
        return app()->getLocale() == 'ar' ? $this->ar_name  : $this->en_name ;
    } 
        public function getFeatures($lang = null)
    {
        if($lang)
        {
          $name = $lang.'_features';
          return $this->$name;
        }
        return app()->getLocale() == 'ar' ? $this->ar_features  : $this->en_features ;
    }    
     public function getDescription($lang = null)
    {
        if($lang)
        {
          $name = $lang.'_description';
          return $this->$name;
        }
        return app()->getLocale() == 'ar' ? $this->ar_description : $this->en_description ;
    } 
    
    public function country(){
    	return $this->hasOne('\App\country','id','country_id');
    }

    public function governorate()
    {
        return $this->belongsTo(Governorate::class, 'governorate_id');
    }
    
    public function isExhibitor()
    {

    }

    public function isAgent()
    {

    }

    public function OwnerInformation()
    {
    	return $this->hasOne('\App\CarHolder','car_id','id');
    }



    public function Images()
    {
        return $this->hasMany('\App\carImages','car_id','id');
    }

    public function Price()
    {
        return $this->hasOne('\App\carPrices','car_id','id');
    }

    public function brand()
    {
        return $this->hasOne('\App\brands','id','ar_brand');
    }

    public function model()
    {
        return $this->hasOne('\App\models','id','ar_model');
    }
    public function agents()
    {
        return $this->belongsTo(Agents::class,'agent_id','id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function memberships()
    {
        return $this->belongsTo(AdsMembership::class,'special','id');
    } 
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class,'vehicle_id');
    }



}
