<?php

namespace App;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exhibition extends Model
{
    use SoftDeletes;
 

    public function country()
    {
    	return $this->belongsTo(country::class);
    }

    public function branchers()
    {
        return $this->hasMany('\App\ExhibitorBranches','exhibitor_id','id');
    }

    public function owner()
    {
    	return $this->hasOne('\App\User','id','user_id');
    }

    public function phones()
    {
    	return $this->hasMany('\App\exhibitionPhones','exhbitor_id','id');
    }

    public function Car()
    {
        return $this->hasOne('\App\CarHolder','is_exhibitor','id');
    }

}
