<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryPerPage extends Model
{
    public function page()
    {
    	return $this->hasOne('\App\Pages','id','id');
    }

     public function category()
    {
    	return $this->hasOne('\App\categories','id','category_id');
    }
}
