<?php

namespace App;

use App\brands;
use App\Vehicle;
use Illuminate\Database\Eloquent\Model;

class brands extends Model
{

    protected $fillable = ['status','name','vehicle_id','manufacturing_country'];
    protected $hidden=['created_at','updated_at'];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }
    
  
   /* public function brands(){
    	return $this->hasMany('\App\models','brand_id','id');
    }*/



}
