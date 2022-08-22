<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConditionItem extends Model
{
    protected $table = 'condition_items';
    protected $hidden=['created_at','updated_at'];
    protected $fillable = ['AddonNameAR' , 'AddonNameEn' , 'AddonMaxYear' , 'AddonUnkownMaxmum' , 'condition_id'];
}
