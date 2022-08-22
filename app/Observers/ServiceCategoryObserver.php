<?php

namespace App\Observers;

use App\Store;
use App\ServiceMemberShip;
use App\ServiceSubCategory;
use App\ServiceChildCategory;

class ServiceCategoryObserver
{
    public function deleted($category)
    {
        $sub_categories_ids =  ServiceSubCategory::where('service_category_id',$category->id)->get()->pluck('id');
        ServiceSubCategory::where('service_category_id',$category->id)->delete();
        ServiceChildCategory::whereIn('service_sub_category_id',$sub_categories_ids)->delete();
        Store::where('category',$category->id)->delete();
        ServiceMemberShip::where('category',$category->id)->delete();
    }
}
