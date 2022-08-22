<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
class SubCat extends Model
{
   //use SoftDeletes;
    protected $table = 'subCats';


    protected $fillable=['name_ar','name_en','image','cat_id','status'];
    
     public function cats()
    {
    	return $this->belongsTo('\App\Cat','cat_id','id');
    }
    public function getName($lang = null)
    {
        if($lang)
        {
          $name ='name_'.$lang;
          return $this->$name;
        }
        return app()->getLocale() == 'ar' ? $this->name_ar  : $this->name_en ;
    } 
}
