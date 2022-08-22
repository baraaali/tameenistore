<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $table = 'banners';
    public $timestamps=false;
    protected $fillable = ['name_ar' , 'name_en','price','type','page','duration'];

    public function getName($lang = null)
    {
        if($lang)
        {
          $name = 'name_'.$lang;
          return $this->$name;
        }
        return app()->getLocale() == 'ar' ? $this->name_ar  : $this->name_en ;
    }
//    public function country(){
//        return $this->belongsTo('\App\country','country_id','id');
//    }

}
