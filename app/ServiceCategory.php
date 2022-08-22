<?php

namespace App;

use App\ServiceCategory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\ServiceCategoryObserver;

class ServiceCategory extends Model
{
    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();

        ServiceCategory::observe(new ServiceCategoryObserver);
    }

    public function getName($lang = null)
    {
        if($lang)
        {
          $name = $lang.'_name';
          return $this->$name;
        }
        return app()->getLocale() == 'ar' ? $this->ar_name  : $this->en_name ;
    }

    public function getDescription($lang = null)
    {
        if($lang)
        {
          $name = $lang.'_description';
          return $this->$name;
        }
        return app()->getLocale() == 'ar' ? $this->ar_description  : $this->en_description ;
    }
}
