<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Style extends Model
{

    protected $fillable = ['name_en','name_ar','created_at','updated_at'];
    protected $table='uses';
    public $timestamps = false;
    public function brands(){
    	return $this->hasMany('\App\models','brand_id','id');
    }
}
