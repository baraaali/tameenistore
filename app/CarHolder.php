<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarHolder extends Model
{
    public function User(){
    	return $this->hasOne('\App\User','id','is_user');
    }

    public function agent(){
    	return $this->hasOne('\App\Agents','id','is_agent');
    }

    public function exhibitor(){
    	return $this->hasOne('\App\Exhibition','id','is_exhibitor');
    }

    public function cars(){
    	return $this->hasMany('\App\Cars','id','car_id');
    }
}
