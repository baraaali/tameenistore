<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
class MiniSubCat extends Model
{
   //use SoftDeletes;
    protected $table = 'miniSubCat';


    protected $fillable=['name_ar','name_en','subCat_id'];
    
     public function subCats()
    {
    	return $this->belongsTo('\App\SubCat','subCat_id','id');
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
