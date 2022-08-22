<?php

namespace App;

use App\MaintenanceRequest;
use Illuminate\Database\Eloquent\Model;

class McenterRate extends Model
{
    protected $guarded = ['id'];


    public function getRateResults()
    {
        $results =  $this->quality + $this->delivery_time + $this->delay_again;
        $results /= 3;
        return number_format($results,2);
    }
    public static function boot()
    {
        parent::boot();
        self::created(function($model){
        });

       self::updated(function($model){
           if($model->isDirty('status'))
           {
           }
       });

    }

}
