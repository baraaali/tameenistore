<?php

namespace App;

use App\Vehicle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Insurancetemplate extends Model
{
     protected $table='insurance_templates';

     protected $fillable=['ar_term','en_term','year','Insurance_Company_ar',
         'Insurance_Company_en','logo','deliveryFee','precent','discount_q',
         'start_disc','end_disc','type','type_of_use','in_duration','status','user_id',
         'end_date','country_id','vehicle_id'];

    public $timestamps = false;

    public function insurnaces()
    {
        return $this->hasMany('\App\InsuranceDocument','id','other_id');
    }
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

//    public function scopeSelectionExcpt($q)
//    {
//        return $q->select('');
//    }

}//end class
