<?php

namespace App\Observers;

use App\Store;
use App\ServiceMemberShip;

class ServiceChildCategoryObserver
{
    public function deleted($category)
    {
      Store::where('child_category',$category->id)->delete();
      ServiceMemberShip::where('child_category',$category->id)->delete();

    }
}
