<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
class Cat extends Model
{
   //use SoftDeletes;
    protected $table = 'cats';


    protected $fillable=['name_ar','name_en','image','status'];

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
