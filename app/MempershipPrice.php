<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class brands extends Model
{

    protected $fillable = ['status','name'];
    public function brands(){
    	return $this->hasMany('\App\models','brand_id','id');
    }
}
