<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'bookings';
    protected $fillable = ['user_id' , 'car_id' , 'name','from_date' , 'to_date','owner_id',
        'address','phone'];

    public function cars(){
        return $this->belongsTo('\App\Cars','car_id','id');
    }
    public function owner(){
        return $this->belongsTo('\App\User','owner_id','id');
    }
}
