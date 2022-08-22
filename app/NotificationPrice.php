<?php

namespace App;

use DateTime;
use Illuminate\Database\Eloquent\Model;

class NotificationPrice extends Model
{
     protected $guarded = ['id'];

     public function getCreatedAtAttribute($date)
     {
      return date_format(new DateTime($date),'d-m-Y H:i:s');
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
}
