<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agents extends Model
{
    protected $fillable=['country_id','user_id','en_name','agent_id',
        'ar_name','en_address','ar_address','phones','image',
        'agent_type','fb_page','instagram','twitter_page','website','email'
        ,'google_map','days_on','times_on','car_type','special','visitors','status'];
	use SoftDeletes;

     public function country()
    {
    	return $this->belongsTo(country::class);
    }
    public function getName($lang = null)
    {
        if($lang)
        {
          $name = $lang.'_name';
          return $this->$name;
        }
        return app()->getLocale() == 'ar' ? $this->ar_name  : $this->en_name ;
    } 

    public function owner()
    {
    	return $this->hasOne('\App\User','id','user_id');
    }
    public function Car()
    {
        return $this->hasOne('\App\CarHolder','is_agent','id');
    }

    public function cars()
    {
        return $this->hasMany('\App\Cars','agent_id','id');
    }
    public function carsCount()
    {
       return Cars::where('status',1)->where('agent_id',$this->id)->count();
    }


}//end class
