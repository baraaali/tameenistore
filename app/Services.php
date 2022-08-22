<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Services extends Model
{
    use SoftDeletes;

    public function Category()
    {
    	return $this->hasOne('\App\Categories','id','category_id');
    }
}
