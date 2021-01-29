<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use App\Country;

class RideController extends Controller
{
    protected $UserAPI;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserApiController $UserAPI)
    {
        $this->middleware('auth');
        $this->UserAPI = $UserAPI;
    }


    /**
     * Ride Confirmation.
     *
     * @return \Illuminate\Http\Response
     */
    public function confirm_ride(Request $request)
    {
       
       
        $fare = $this->UserAPI->estimated_fare($request)->getData();
        $service = (new Resource\ServiceResource)->show($request->service_type);
        $cards = (new Resource\CardResource)->index();
        $promolist = $this->UserAPI->list_promocode($request); 

        $countryId=Auth::user()->country_id;
        $present_country_code=$request->country_code; 


        if($request->has('current_longitude') && $request->has('current_latitude'))
        {
            User::where('id',Auth::user()->id)->update([
                'latitude' => $request->current_latitude,
                'longitude' => $request->current_longitude
            ]);
        } 
        if(!empty($request->country_code))
        {
                $county= Country::wherecode($request->country_code)->first();  

                $present_riding_country_id=$county->id;
                $present_riding_currency_code=$county->currency_code;
          

                if(Auth::user()->country_id==$present_riding_country_id)
                {
                    $present_riding_country_id=1;
                }
                else
                {
                    $present_riding_country_id=0;
                }
                
          }

        return view('user.ride.confirm_ride',compact('request','fare','service','cards','promolist','countryId','present_country_code','present_riding_country_id','present_riding_currency_code')); 
    }

    /**
     * Create Ride.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_ride(Request $request)
    {
        return $this->UserAPI->send_request($request);
    }

    /**
     * Get Request Status Ride.
     *
     * @return \Illuminate\Http\Response
     */
    public function status()
    {
        return $this->UserAPI->request_status_check();
    }

    /**
     * Cancel Ride.
     *
     * @return \Illuminate\Http\Response
     */
    public function cancel_ride(Request $request)
    {
        return $this->UserAPI->cancel_request($request);
    }

    /**
     * Rate Ride.
     *
     * @return \Illuminate\Http\Response
     */
    public function rate(Request $request)
    {
        return $this->UserAPI->rate_provider($request);
    }
}
