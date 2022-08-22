<?php

namespace App\Console\Commands;

use App\Cars;
use App\User;
use App\items;
use App\Mcenters;
use App\NewServices;
use Illuminate\Console\Command;
use App\Events\NotificationEvent;

class AdExpired extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ad:expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send notfication to user when the ad is expired';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    public function sendNotification($ads,$purpose,$target)
    {
        foreach ($ads as $ad) {
            $user_id = $ad->user_id;
            $user = User::where('id',$user_id)->first();

            if(!empty($user)){
                NotificationEvent::dispatch(["purpose"=>$purpose,"params"=>['email'=>$user->email]]);
                sleep(5);

            }
        }
    }


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // check commercial ads
        $items = items::select('user_id')->distinct()->where('status',1)->whereDate('items.end_ad_date', '>', date('Y-m-d'))->get();
        $this->sendNotification($items,'ad_renewal','items');

        // check cars ads
        $cars = Cars::select('user_id')->distinct()->where('status',1)->whereDate('cars.end_ad_date', '>', date('Y-m-d'))->get();
        $this->sendNotification($cars,'ad_renewal','Cars');

        //check services
        $services = NewServices::select('user_id')->distinct()->where('status',1)->whereDate('services_new.end_date', '>', date('Y-m-d'))->get();
        $this->sendNotification($services,'ad_renewal','NewServices');

        //check mcenters
        $mcenters = Mcenters::select('user_id')->distinct()->where('status','1')->whereDate('renewal_at', '>', date('Y-m-d'))->get();
        $this->sendNotification($mcenters,'membership_renewal','Mcenters');

        
        return 0;
    }
}
