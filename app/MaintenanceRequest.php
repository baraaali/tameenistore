<?php

namespace App;

use App\User;
use App\Mcenters;
use App\McenterRate;
use App\UserNotification;
use App\Events\NotificationEvent;
use App\McenterAdditionalService;
use Illuminate\Support\Facades\Lang;
use Illuminate\Database\Eloquent\Model;

class MaintenanceRequest extends Model
{
    protected $guarded = ['id'];

   
    public function rate()
    {
        return $this->hasOne(McenterRate::class, 'maintenance_request_id','id');
    }

    public function mcenter()
    {
        return $this->belongsTo(Mcenters::class, 'mcenter_id');
    } 


    public function services()
    {
        $ids = explode('-',$this->services);
        return McenterService::whereIn('id',$ids)->get();
    }
    public function additionalServices()
    {
        $ids = explode('-',$this->additional_services);
        return McenterAdditionalService::whereIn('id',$ids)->get();
    } 
  
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
     public function time()
    {
        $time = explode('-',$this->delivery_time);
        $start = $time[0];
        $end = $time[1];
        $start_number = explode('_',$start)[0];
        $start_period = Lang::get('site.'.explode('_',$start)[1]);
        $end_number = explode('_',$end)[0];
        $end_period = Lang::get('site.'.explode('_',$end)[1]);
        return $start_number.':00 '.$start_period.' - '.$end_number.':00 '.$end_period;
        
    }

    public static function boot()
    {
        parent::boot();
        self::created(function($model){
            $mcenter = Mcenters::where('id',$model->mcenter_id)->first();
            NotificationEvent::dispatch(["purpose"=>"get_mcenter_seller_request","params"=>['email'=>$mcenter->owner->email]]);
        });

       self::updated(function($model){
           if($model->isDirty('status'))
           {
            $user = $model->user ;
            NotificationEvent::dispatch(["purpose"=>"get_mcenter_change_request","params"=>['email'=>$user->email]]);
           }
       });

    }
	
}
