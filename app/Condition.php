<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Condition extends Model
{
    protected $table = 'conditions';
    protected $hidden=['created_at','updated_at'];
    protected $fillable = ['ToleranceratioCheck' , 'Tolerance_ratio' , 'ToleranceYearPerecenteage' , 'ConsumptionRatio'
    , 'ConsumptionFirstRatio', 'YearPerecenteage', 'ConsumptionYearPerecenteage','last_percent_en','last_percent','insurance_document_id'];
    public function condition_items()
        {
            return $this->hasMany('App\ConditionItem');
        }
}
