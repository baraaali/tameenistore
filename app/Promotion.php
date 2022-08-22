<?php

namespace App;

use App\Cars;
use App\City;
use DateTime;
use App\items;
use App\Governorate;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $guarded = ['id'];

    public function getCreatedAtAttribute($date)
    {
     return date_format(new DateTime($date),'d-m-Y H:i:s');
    }

   
    public function ad($p)
    {
        if($p->ad_type == 'categories')
        return $this->belongsTo(items::class, 'ad_id');
        else if($p->ad_type == 'cars')
        return $this->belongsTo(Cars::class, 'ad_id');
    }

    public function target($p,$count = false)
    {
        $countries_ids = !empty($p->countries) ? explode('-',$p->countries ): [];
        $governorate_ids = !empty($p->governorates) ? explode('-',$p->governorates ): [];
        $city_ids = !empty($p->city_ids) ? explode('-',$p->city_ids ): [];
        $name = app()->getLocale() == 'ar' ? 'ar_name' : 'en_name';
        if(!empty($city_ids)) 
        {
            if($count)
            return City::whereIn('id',$city_ids)->get()->count();
            return implode(' - ', City::whereIn('id',$city_ids)->get()->pluck($name)->toArray());
       
        }else if(!empty($governorate_ids)){
            if($count)
            return Governorate::whereIn('id',$governorate_ids)->get()->count();
            return implode(' - ', Governorate::whereIn('id',$governorate_ids)->get()->pluck($name)->toArray());
        }
       
        else if(!empty($countries_ids))
            if($count)
            return country::whereIn('id',$countries_ids)->get()->count();
            return implode(' - ', country::whereIn('id',$countries_ids)->get()->pluck($name)->toArray());

    }

}
