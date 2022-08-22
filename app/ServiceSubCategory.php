<?php

namespace App;

use App\ServiceCategory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\ServiceSubCategoryObserver;

class ServiceSubCategory extends Model
{
    protected $guarded = ['id'];
    
    public static function boot()
    {
        parent::boot();

        ServiceSubCategory::observe(new ServiceSubCategoryObserver);
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

    /**
     * Get the ServiceCategory that owns the ServiceSubCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function serviceCategory()
    {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }
}
