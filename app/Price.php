<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Price extends Model
{
    protected $table='prices';
    protected $fillable=['name_ar','name_en','price'];

}
