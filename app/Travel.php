<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Travel extends Model
{
    protected $table = 'travel';
    protected $fillable = ['user_id' , 'ar_com_name' , 'en_com_name','address_ar' , 'address_en','phone',
        'email','logo'];

    public function cars(){
        return $this->belongsTo('\App\Cars','car_id','id');
    }
    public function owner(){
        return $this->belongsTo('\App\User','owner_id','id');
    }
}
