<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Http\Controllers\SendPushNotification;
use App\Http\Controllers\AdminController;
use Carbon\Carbon;
use App\SubscriptionHistories;
use App\UserRequests;
use App\Provider;

class CustomCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cronjob:rides';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updating the Scheduled Rides Timing';

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
     * @return mixed
     */
    public function handle()
    {
        $UserRequest = DB::table('user_requests')->where('status','SCHEDULED')
                        ->where('schedule_at','<=',\Carbon\Carbon::now()->addMinutes(5))
                        ->get();

        $hour =  \Carbon\Carbon::now()->subHour();
        $futurehours = \Carbon\Carbon::now()->addMinutes(5);
        $date =  \Carbon\Carbon::now();           

        \Log::info("Schedule Service Request Started.".$date."==".$hour."==".$futurehours);

        if(!empty($UserRequest)){
            foreach($UserRequest as $ride){
                DB::table('user_requests')
                        ->where('id',$ride->id)
                        ->update(['status' => 'STARTED', 'assigned_at' =>Carbon::now() , 'schedule_at' => null ]);

                 //scehule start request push to user
                (new SendPushNotification)->user_schedule($ride->user_id);
                 //scehule start request push to provider
                (new SendPushNotification)->provider_schedule($ride->provider_id);

                DB::table('provider_services')->where('provider_id',$ride->provider_id)->update(['status' =>'riding']);
            }
        }

        $CustomPush = DB::table('custom_pushes')
                        ->where('schedule_at','<=',\Carbon\Carbon::now()->addMinutes(5))
                        ->get();

        if(!empty($CustomPush)){
            foreach($CustomPush as $Push){
                DB::table('custom_pushes')
                        ->where('id',$Push->id)
                        ->update(['schedule_at' => null ]);

                // sending push
                (new AdminController)->SendCustomPush($Push->id);
            }
        }

         /// Subscription expired or not 

        $check = SubscriptionHistories::with('subscription')->wherestatus('Active')->get();

        foreach ($check as $key => $value) {
            $today = \Carbon\Carbon::now(); 
            $subscription_date= \Carbon\Carbon::parse($value->ended_at); 
            $pro_count = UserRequests::where('provider_id',$value->provider_id)->where('status','COMPLETED')->get()->count();
            if(($today > $subscription_date) || ((int)$value->subscription->rides_per_period <= $pro_count)){
                $check = SubscriptionHistories::findOrfail($value->id);
                $check->status = 'Expired';
                $check->save();

                $provider = Provider::findOrfail($value->provider_id);
                $provider->subscribe = 'notsubscribed';
                $provider->save();
            }
        }


    }
}
