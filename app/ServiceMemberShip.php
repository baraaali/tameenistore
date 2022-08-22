<?php

namespace App;

use App\ServiceCategory;
use App\ServiceSubCategory;
use App\ServiceChildCategory;
use Illuminate\Database\Eloquent\Model;

class ServiceMemberShip extends Model
{
    protected $guarded = ['id'];


    public function getName($lang = null)
    {
        if($lang)
        {
          $name = $lang.'_name';
          return $this->$name;
        }
        return app()->getLocale() == 'ar' ? $this->ar_name  : $this->en_name ;
    }

    public function getCategory()
    {
        $child_category  = ServiceChildCategory::where('id',$this->child_category)->get()->first();
        $sub_category = ServiceSubCategory::where('id',$this->sub_category)->get()->first();
        $category   = ServiceCategory::where('id',$this->category)->get()->first();
        if(!is_null($this->child_category) && !is_null($child_category))
         return $child_category->ar_name;
        if(!is_null($this->sub_category) && !is_null($sub_category))
         return $sub_category->ar_name;
        if(!is_null($this->category) && !is_null($category))
         return $category->ar_name;  
    }
}
