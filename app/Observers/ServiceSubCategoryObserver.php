<?php

namespace App\Observers;

use App\Store;
use App\ServiceMemberShip;
use App\ServiceChildCategory;

class ServiceSubCategoryObserver
{
    public function deleted($category)
    {
      ServiceChildCategory::where('service_sub_category_id',$category->id)->delete();
      Store::where('sub_category',$category->id)->delete();
      ServiceMemberShip::where('sub_category',$category->id)->delete();

    }
}
