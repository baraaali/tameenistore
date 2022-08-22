<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceImg extends Model
{
    protected $table='services_img';
    protected $fillable=['file','service_id'];

    protected $hidden=['created_at','updated_at'];

    public function services()
    {
        return $this->belongsTo(App\NewServices::class,'service_id','id');
    }
}
