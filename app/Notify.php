<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notify extends Model
{

    protected $table='notify';
    protected $fillable = ['ads_id','status'];

    public function cars(){
        return $this->belongsTo('\App\Cars','ads_id');
    }

}
