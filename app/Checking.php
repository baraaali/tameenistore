<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checking extends Model
{
    protected $table = 'checking';
//    public $timestamps=false;
    protected $fillable = ['user_id' , 'type','status','type','duration'];


}
