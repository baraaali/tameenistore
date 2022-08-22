<?php

namespace App;

use App\Vehicle;
use App\membership;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class NewServices extends Model
{
    
    protected $table='services_new';
  protected $fillable=['country_id','gover_id','cat_id','sub_cat','mini_sub_cat','ar_description','en_description','price','start_date','end_date','image','status','user_id','visitor','name_ar','name_en'];
    
    public function country(){
    	return $this->belongsTo('\App\country','country_id','id');
    }

    public function gover(){
        return $this->belongsTo('\App\country','id','country_id');
    }

    public function cats()
    {
        return $this->belongsTo(Cat::class,'cat_id','id');
    }

    public function subCats()
    {
        return $this->belongsTo(SubCat::class,'sub_cat','id');
    }

    public function MiniSubCats()
    {
        return $this->belongsTo(MiniSubCat::class,'mini_sub_cat','id');
    }

      public function images()
    {
        return $this->hasMany(ServiceImg::class,'service_id','id');
    }

     public function users()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
     public function membership()
    {
        return $this->belongsTo(NewServiceMembership::class,'type','id');
    }
    
    public function getName($lang = null)
    {
        if($lang)
        {
          $name = 'name_'.$lang;
          return $this->$name;
        }
        return app()->getLocale() == 'ar' ? $this->name_ar  : $this->name_en ;
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

}
