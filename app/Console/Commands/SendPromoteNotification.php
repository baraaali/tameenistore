<?php

namespace App\Console\Commands;

use App\User;
use App\UserNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendPromoteNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send-promote:notification {promotion*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send promote notifications';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $promotion = $this->argument('promotion');
        $targets = explode('-',$promotion->target($promotion));
        $users_group_1 = User::whereHas('Country',function($q) use ($targets) {
          $q->whereIn('ar_name',$targets)
          ->orWhereIn('en_name',$targets);
        })->get()->toArray();
        $users_group_2 = User::whereHas('governorate',function($q) use ($targets){
            $q->whereIn('ar_name',$targets)
            ->orWhereIn('en_name',$targets);
        })->get()->toArray();
        $users_group_3 = User::whereHas('city',function($q) use ($targets){
            $q->whereIn('ar_name',$targets)
            ->orWhereIn('en_name',$targets);
        })->get()->toArray();

        $users = array_merge($users_group_1,$users_group_2,$users_group_3);

        $notifications = [];
        foreach ($users as $user) {
          array_push($notifications,
          [
                'user_id' => $user['id'],
                'subject' => $promotion['subject'],
                'body' => $promotion['body'],
          ]
        );
        }
        UserNotification::insert($notifications);
        foreach ($users as $user) {
            $data = ['subject'=>$promotion['subject'],'body'=>$promotion['body']];
            Mail::send('emails.notification',['data'=>$data], function($message) use ($user,$data)
            {
                $message->from('info@tameenistore.com', 'tameenistore');
                $message->subject($data['subject']);
                $message->to($user['email']);
            
            });
            sleep(2);
        }
        return 0;
    }
}
