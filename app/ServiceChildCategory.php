<?php

namespace App;

use App\ServiceSubCategory;
use App\ServiceChildCategory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\ServiceChildCategoryObserver;

class ServiceChildCategory extends Model
{
    protected $guarded = ['id'];
    
    public static function boot()
    {
        parent::boot();

        ServiceChildCategory::observe(new ServiceChildCategoryObserver);
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
     * Get the ServiceChildCategory that owns the ServiceChildCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function serviceSubCategory()
    {
        return $this->belongsTo(ServiceSubCategory::class, 'service_sub_category_id');
    }
}
