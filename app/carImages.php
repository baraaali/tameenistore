<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class carImages extends Model
{
    protected $table='car_images';
    protected $fillable=['car_id','image'];

    protected $hidden=['created_at','updated_at'];
}
