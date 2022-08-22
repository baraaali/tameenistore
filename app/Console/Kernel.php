<?php

namespace App\Console;

use Carbon\Carbon;
use App\Console\Commands\AdExpired;
use Illuminate\Support\Facades\Log;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\SendPromoteNotification;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        AdExpired::class,
        SendPromoteNotification::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        
        $schedule->command('ad:expired')
        ->dailyAt('10:00');
       // Log::info("working");

        $schedule->call(function () {
    
            $today = Date('Y-m-d');
            
            $all_cars_ends_today = \App\Cars::where('end_date',$today)->get();
            $all_insuranceCompany = \App\Insurance::select('user_id')->get();
            $users = \App\User::whereIn('id',$all_insuranceCompany->pluck('user_id'))->whereDate('ended_at',Carbon::today())->select('id')->get();
            
            foreach($users as $user) {
                $dd_el8er = \App\InsuranceDocument::where('user_id',$user->id)->get();
                foreach($dd_el8er as $el8er) {
                    $el8er->status = 0;
                    $el8er->save();
                }
                
                $el_shamels = \App\CompleteDoc::where('user_id',$user->id)->get();
                foreach($el_shamels as $elshamel) {
                    $elshamel->status = 0;
                    $shamel->save();
                }
            }
            
            foreach($all_cars_ends_today as $car) {
                $car->status = 0;
                $car->save();
            }
            
        })->dailyAt('00:00');
    
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
