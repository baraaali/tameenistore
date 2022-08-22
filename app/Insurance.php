<?php

namespace App;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Insurance extends Model
{
    use SoftDeletes;
 
    protected $table = 'insurance';
    
    public function country()
    {
    	return $this->belongsTo(country::class);
    }

    public function documents()
    {
        return $this->hasMany('\App\InsuranceDocument','insurance_id','id');
    }

    public function owner()
    {
    	return $this->hasOne('\App\User','id','user_id');
    }

}
