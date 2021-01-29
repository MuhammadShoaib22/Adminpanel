<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Eventcontact;


use App\ServiceType;
use App\UserWallet;
use Auth;
use Setting;
use App\Helpers\Helper;
use App\Country;
use App\Cities;
use App\WalletPassbook;
use GuzzleHttp\Client;

class HomeController extends Controller
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
        $this->middleware('demo', ['only' => [
                'update_password',
            ]]);
        $this->UserAPI = $UserAPI;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $Response = $this->UserAPI->request_status_check()->getData();
        $selectedcountry=Auth::user()->country_id;  
        $CountryCode=Country::find($selectedcountry);

        if(empty($Response->data))
        { 
         $services = $this->UserAPI->services();
            return view('user.dashboard',compact('services','CountryCode'));
        }else{
            return view('user.ride.waiting')->with('request',$Response->data[0]);
        }
    }

    /**
     * Show the application profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {


        return view('user.account.profile');
    }


 

    /**
     * Show the application profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit_profile()
    {
        $countries = Country::where('status',1)->get();
        $selectedcountry=Auth::user()->country_id; 
        $selectedcity=Auth::user()->city_id; 

        $country_city=Cities::wherecountry_code(Auth::user()->country->code)->wherestatus(1)->get();

        return view('user.account.edit_profile',compact('countries','selectedcountry','selectedcity','country_city'));
    }

    /**
     * Update profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function update_profile(Request $request)
    {
        return $this->UserAPI->update_profile($request);
    }

    /**
     * Show the application change password.
     *
     * @return \Illuminate\Http\Response
     */
    public function change_password()
    {
        return view('user.account.change_password');
    }

    /**
     * Change Password.
     *
     * @return \Illuminate\Http\Response
     */
    public function update_password(Request $request)
    {
        return $this->UserAPI->change_password($request);
    }

    /**
     * Trips.
     *
     * @return \Illuminate\Http\Response
     */
    public function trips()
    {
        $trips = $this->UserAPI->trips();
        return view('user.ride.trips',compact('trips'));
    }

     /**
     * Payment.
     *
     * @return \Illuminate\Http\Response
     */
    public function payment()
    {
        $cards = (new Resource\CardResource)->index();
        return view('user.account.payment',compact('cards'));
    }


    /**
     * Wallet.
     *
     * @return \Illuminate\Http\Response
     */
    public function wallet(Request $request)
    {

        $cards = (new Resource\CardResource)->index();

        $wallet_transation = UserWallet::where('user_id',Auth::user()->id)->orderBy('id','desc')
                                ->paginate(Setting::get('per_page', '10'));
            
        $pagination=(new Helper)->formatPagination($wallet_transation); 
        if(Auth::user()->country_id==Auth::user()->present_riding_country_id)
        {
            $present_riding_country_id=1;
        }
        else
        {
            $present_riding_country_id=0;
        }
        $countryId=Auth::user()->country_id;
        
        return view('user.account.wallet',compact('wallet_transation','pagination','cards','present_riding_country_id','countryId')); 
    }

    /**
     * Promotion.
     *
     * @return \Illuminate\Http\Response
     */
    public function promotions_index(Request $request)
    {
        $promocodes = $this->UserAPI->promocodes();
        return view('user.account.promotions', compact('promocodes'));
    }

    /**
     * Add promocode.
     *
     * @return \Illuminate\Http\Response
     */
    public function promotions_store(Request $request)
    {
        return $this->UserAPI->add_promocode($request);
    }

    public function wallet_verify(Request $request)
    {
         // dd($request->all());
        $paisa = $request->auth_token;
        return view('user.ride.paisa' , compact('paisa'));
       
    }

   


     public function paisa_wallet_form(Request $request)
    {
        $val =  number_format($request->amount, 1);
        $random_store_id = 'WAL'.rand ( 10000 , 99999 );

          $Wallet= new WalletPassbook();
        $Wallet->amount=$request->amount;
        $Wallet->user_id=Auth::user()->id;
        $Wallet->payment_id = $random_store_id;
        $Wallet->status='UNPAID';
        $Wallet->via= 'easypaisa';
        $Wallet->save();


         return view('user.ride.wallet_form' , compact('val','random_store_id'));

    }






// end encryption;

    /**
     * Upcoming Trips.
     *
     * @return \Illuminate\Http\Response
     */
    public function upcoming_trips()
    {
        $trips = $this->UserAPI->upcoming_trips();
        return view('user.ride.upcoming',compact('trips'));
    }

    public function incoming()
    {
        $Response = $this->UserAPI->request_status_check()->getData();
        
        if(empty($Response->data))
        { 
            return response()->json(['status' => 0]);
        }else{
            return response()->json(['status' => 1]);
        }
    }

     


   
}
