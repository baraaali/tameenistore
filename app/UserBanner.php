<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserBanner extends Model
{
    protected $table = 'user_banners';
    protected $guarded = ['id'];


    public function country(){
        return $this->belongsTo('\App\country','country_id','id');
    }

    public function user(){
        return $this->belongsTo('\App\User','user_id','id');
    }

    public function Banner(){
        return $this->belongsTo('\App\Banner','banner_id','id');
    }

}
