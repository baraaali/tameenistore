<?php

namespace App\Listeners;

use App\User;
use App\AutoNotification;
use App\UserNotification;
use App\Events\NotificationEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NotificationEvent  $event
     * @return void
     */
    public function handle(NotificationEvent $event)
    {
        $purpose = $event->data['purpose'];
        $params = $event->data['params'];
        $autoNotification = AutoNotification::where('purpose',$purpose)->get()->first();
        if(!is_null($autoNotification))
        {
         $autoNotification = $autoNotification->toArray();
        if(!is_null($autoNotification) && $autoNotification['status'] === 'active')
        {
            $data = $this->transformData($autoNotification,$event->data);
            Mail::send('emails.notification',['data'=>$data], function($message) use ($data,$params)
            {
                $message->from('info@tameenistore.com', 'tameenistore');
                $message->subject('tameenistore notification');
                $message->to($params['email']);
            
            });

            // save Notification
            $notification =  new UserNotification();
            $user = User::where('email',$params['email'])->first();
            $notification->user_id = $user->id;
            $notification->subject = 'notification - إشعار';
            $notification->body = $autoNotification['body'];
            $notification->viewed = '0';
            $notification->save();

        }
        }

    }

    public function transformData($autoNotification,$data)
    {  
            return $autoNotification;
             //$body = $autoNotification['body'];
             /*   switch ($data['purpose']) {
                case 'welcome_message':
                $body = str_replace('[إسم العميل]',$data['params']['full_name'],$body);
                $body = str_replace('[البريد الإلكتروني]',$data['params']['email'],$body);
                $body = str_replace('[كلمة المرور]',$data['params']['password'],$body);
                $autoNotification['body'] = $body;
                return $autoNotification;
                break;
                case 'password_recovery':
                return ['[إسم العميل]','[البريد الإلكتروني]','[كلمة المرور الجديدة]']     
                    break;
                case 'balance_discount':
                return ['[إسم العميل]','[الرصيد]']    
                    break;  
                 case 'add_credit':
                 return ['[إسم العميل]','[الرصيد]']    
                    break;
                case 'new_ad':
                return ['[إسم العميل]','[عنوان الإعلان]']    
                    break;
                case 'ad_renewal':
                return ['[إسم العميل]','[عنوان الإعلان]','[عدد الأيام]','[تاريخ الإنتهاء]']    
                    break;
                case 'advertisement_expiration_date':
                return ['[إسم العميل]','[عنوان الإعلان]']    
                    break;
                case 'membership_renewal':
                return ['[إسم العميل]','[إسم العضوية]','[تاريخ الإنتهاء]']    
                    break;
                case 'membership_expiry':
                return ['[إسم العميل]','[إسم العضوية]','[تاريخ الإنتهاء]']    
                    break;
                case 'comprehensive_insurance_request_for_merchants':
                return ['[إسم العميل]']    
                    break; 
                case 'request_a_rental_car_reservation' :
                return ['[إسم العميل]']    
                    break;
                case 'third_party_insurance_claim_for_traders':
                return ['[إسم العميل]']    
                    break;
                    
        }*/
    }
}
