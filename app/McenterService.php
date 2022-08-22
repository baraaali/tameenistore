<?php

namespace App;

use App\Mcenters;
use App\McenterVehicle;
use Illuminate\Database\Eloquent\Model;

class McenterService extends Model
{
    protected $guarded = ['id'];


    public function getName($lang = null)
    {
        if($lang)
        {
          $name = $lang.'_name';
          return $this->$name;
        }
        return app()->getLocale() == 'ar' ? $this->ar_name  : $this->en_name ;
    } 
     public function getDescription($lang = null)
    {
        if($lang)
        {
          $name = $lang.'_description';
          return $this->$name;
        }
        return app()->getLocale() == 'ar' ? $this->ar_description  : $this->en_description ;
    }

    public function addtionalServices()
    {
        return $this->hasMany(McenterAdditionalService::class, 'mcenter_service_id');
    }

    public function mcenter()
    {
        return $this->belongsTo(Mcenters::class, 'mcenter_id');
    } 
    public function vehicle()
    {
        return $this->belongsTo(McenterVehicle::class, 'mcenter_vehicle_id');
    }
}
