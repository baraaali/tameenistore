<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table = 'plans';
    protected $fillable = ['user_id' , 'travel_id','plan1_young' , 'plan1_child','plan1_old' , 'plan2_young','plan2_child' ,
        'plan2_old','plan3_young' , 'plan3_child','plan3_old' , 'type','add_plan1_young' , 'add_plan1_child',
        'add_plan1_old' , 'add_plan2_young','add_plan2_child' , 'add_plan2_old','add_plan3_young' , 'add_plan3_child',
        'add_plan3_old','conditions','advantages' ];

    public function User(){
        return $this->belongsTo('\App\User','user_id','id');
    }

    public function travel(){
        return $this->belongsTo('\App\Travel','travel_id','id');
    }

}
