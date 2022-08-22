<?php

namespace App;

use App\CareShape;
use Illuminate\Database\Eloquent\Model;

class models extends Model
{
    protected $fillable = ['status','name','brand_id','passengers','care_shape_id'];
    protected $hidden=['created_at','updated_at'];
    public function brands(){
        return $this->belongsTo('\App\brands','brand_id','id');
    }
 
    public function careshape()
    {
        return $this->belongsTo(CareShape::class, 'care_shape_id');
    }

   


}
