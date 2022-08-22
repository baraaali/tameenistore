<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Pages extends Model
{
    use SoftDeletes;

    public function categories()
    {
    	return $this->hasMany('\App\CategoryPerPage','page_id','id');
    }

    
}
