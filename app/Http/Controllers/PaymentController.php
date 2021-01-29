<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\SendPushNotification;

use Stripe\Charge;
use Stripe\Stripe;
use Stripe\StripeInvalidRequestError;
use App\Helpers\Helper;

use Auth;
use Setting;
use Exception;

use App\Card;
use App\ProviderCard;
use App\User;
use App\WalletPassbook;
use App\UserRequests;
use App\UserRequestPayment;
use App\WalletRequests;
use App\Provider;
use App\Fleet;
use App\Subscriptions;
use App\SubscriptionHistories;
use App\provider_subscription_log;
use App\ProviderWallet;

use App\Http\Controllers\ProviderResources\TripController;

class PaymentController extends Controller
{
       /**
     * payment for user.
     *
     * @return \Illuminate\Http\Response
     */
    public function payment(Request $request)
    {

        $this->validate($request, [
                'request_id' => 'required|exists:user_request_payments,request_id|exists:user_requests,id,paid,0,user_id,'.Auth::user()->id
            ]);


        $UserRequest = UserRequests::find($request->request_id);
        
        $tip_amount=0;

        if($UserRequest->payment_mode == 'CARD') {

            $RequestPayment = UserRequestPayment::where('request_id',$request->request_id)->first(); 
            
            if(isset($request->tips) && !empty($request->tips)){
                $tip_amount=round($request->tips,2);
            }
            
            $StripeCharge = ($RequestPayment->payable+$tip_amount) * 100;
            
           
            try {

                $Card = Card::where('user_id',Auth::user()->id)->where('is_default',1)->first();
                $stripe_secret = Setting::get('stripe_secret_key');

                Stripe::setApiKey(Setting::get('stripe_secret_key'));
                
                if($StripeCharge  == 0){

                $RequestPayment->payment_mode = 'CARD';
                $RequestPayment->card = $RequestPayment->payable;
                $RequestPayment->payable = 0;
                $RequestPayment->tips = $tip_amount;                
                $RequestPayment->provider_pay = $RequestPayment->provider_pay+$tip_amount;
                $RequestPayment->save();

                $UserRequest->paid = 1;
                $UserRequest->status = 'COMPLETED';
                $UserRequest->save();

                //for create the transaction
                (new TripController)->callTransaction($request->request_id);

                if($request->ajax()) {
                   return response()->json(['message' => trans('api.paid')]); 
                } else {
                    return redirect('dashboard')->with('flash_success', trans('api.paid'));
                }
               }else{
                
                $Charge = Charge::create(array(
                      "amount" => $StripeCharge,
                      "currency" => "usd",
                      "customer" => Auth::user()->stripe_cust_id,
                      "card" => $Card->card_id,
                      "description" => "Payment Charge for ".Auth::user()->email,
                      "receipt_email" => Auth::user()->email
                    ));

                /*$ProviderCharge = (($RequestPayment->total+$RequestPayment->tips - $RequestPayment->tax) - $RequestPayment->commision) * 100;

                $transfer = Transfer::create(array(
                    "amount" => $ProviderCharge,
                    "currency" => "usd",
                    "destination" => $Provider->stripe_acc_id,
                    "transfer_group" => "Request_".$UserRequest->id,
                  )); */    

                    $RequestPayment->payment_id = $Charge["id"];
                    $RequestPayment->payment_mode = 'CARD';
                    $RequestPayment->card = $RequestPayment->payable;
                    $RequestPayment->payable = 0;
                    $RequestPayment->tips = $tip_amount;
                    $RequestPayment->provider_pay = $RequestPayment->provider_pay+$tip_amount;
                    $RequestPayment->save();

                    $UserRequest->paid = 1;
                    $UserRequest->status = 'COMPLETED';
                    $UserRequest->save();

                    //for create the transaction
                    (new TripController)->callTransaction($request->request_id);

                    if($request->ajax()) {
                    return response()->json(['message' => trans('api.paid')]); 
                    } else {
                    return redirect('dashboard')->with('flash_success', trans('api.paid'));
                    }
                    }

                    } catch(StripeInvalidRequestError $e){

                    if($request->ajax()){
                    return response()->json(['error' => $e->getMessage()], 500);
                    } else {
                    return back()->with('flash_error', $e->getMessage());
                    }
                    } catch(Exception $e) {
                    if($request->ajax()){
                    return response()->json(['error' => $e->getMessage()], 500);
                    } else {
                    return back()->with('flash_error', $e->getMessage());
                    }

                }
        }
    }

    public function send_money_trans(Request $request){

        $this->validate($request, [
                'country_code' => 'required',
                'amount' => 'required'
            ]);
        try {

          $toUser = Provider::where('mobile',$request->country_code.$request->mobile)->whereNotIn('mobile',[Auth::user()->mobile])->first();
          if(!$toUser){
          $toUser = Provider::where('mobile',$request->mobile)->whereNotIn('mobile',[Auth::user()->mobile])->first();
          }
          
          if(!$toUser) {
            if($request->ajax()) {
                return response()->json(['error' => trans('api.mobile_unavailable')], 500);
            } else {
                return back()->with('flash_error', trans('api.mobile_unavailable'));
            }
          } else {
            $fromUser = Provider::where('id',Auth::user()->id)->decrement('wallet_balance',$request->amount);
            $toUser->wallet_balance += $request->amount;
            $toUser->save();
            WalletPassbook::create([
              'user_id' => Auth::user()->id,
              'amount' => $request->amount,
              'status' => 'DEBITED',
              'via' => 'WALLET_TRANSFER',
            ]);
        $providerWallet=new ProviderWallet;        
        $providerWallet->provider_id=Auth::user()->id;        
        $providerWallet->transaction_id=ProviderWallet::where('transaction_alias','LIKE','%PWALLET%')->count() +1;;        
        $providerWallet->transaction_alias=(new Helper)->generate_request_id('provider_wallet');
        $providerWallet->transaction_desc='Transfer to '.$toUser->first_name;
        $providerWallet->type='D';
        $providerWallet->amount=$request->amount;

        if(empty(Auth::user()->wallet_balance))
            $providerWallet->open_balance=0;
        else
            $providerWallet->open_balance=Auth::user()->wallet_balance;

        if(empty(Auth::user()->wallet_balance))
            $providerWallet->close_balance=$request->amount;
        else            
            $providerWallet->close_balance=Auth::user()->wallet_balance-$request->amount;        

        $providerWallet->save();

            WalletPassbook::create([
              'user_id' => $toUser->id,
              'amount' => $request->amount,
              'status' => 'CREDITED',
              'via' => 'WALLET_TRANSFER',
            ]);
        $providerWalletx=new ProviderWallet;        
        $providerWalletx->provider_id=$toUser->id;        
        $providerWalletx->transaction_id=ProviderWallet::where('transaction_alias','LIKE','%PWALLET%')->count() +1;;        
        $providerWalletx->transaction_alias=(new Helper)->generate_request_id('provider_wallet');
        $providerWalletx->transaction_desc='Received from '.Auth::user()->first_name;
        $providerWalletx->type='C';
        $providerWalletx->amount=$request->amount;

        if(empty($toUser->wallet_balance))
            $providerWalletx->open_balance=0;
        else
            $providerWalletx->open_balance=$toUser->wallet_balance;

        if(empty($toUser->wallet_balance))
            $providerWalletx->close_balance=$request->amount;
        else            
            $providerWalletx->close_balance=$toUser->wallet_balance+$request->amount;        

        $providerWalletx->save();
            if($request->ajax()) {
                return response()->json(['message' => currency($request->amount).' '.trans('api.amount_transferred')]);
            } else {
                return back()->with('flash_success', currency($request->amount).' '.trans('api.amount_transferred'));
            }
          }

        } catch(Exception $e) {
            if($request->ajax()) {
                return response()->json(['error' => $e->getMessage()], 500);
            } else {
                return back()->with('flash_error', $e->getMessage());
            }
        }
    }


    public function api_paisa__data(Request $request){

      return $request->all();
    }

    /**
     * add wallet money for user.
     *
     * @return \Illuminate\Http\Response
     */
    // public function add_money(Request $request){


    //     $this->validate($request, [
    //             'amount' => 'required|integer',
    //             'card_id' => 'required|exists:cards,card_id,user_id,'.Auth::user()->id
    //         ]);

    //     try{
            
    //         $StripeWalletCharge = $request->amount * 100;

    //         Stripe::setApiKey(Setting::get('stripe_secret_key'));

    //         $wallet_balance=Auth::user()->wallet_balance+$request->amount;

    //         if($request->ajax()){
    //             return response()->json(['success' => symbolcurrency($request->amount,Auth::user()->country->currency_code)." ".trans('api.added_to_your_wallet'), 'message' => symbolcurrency($request->amount,Auth::user()->country->currency_code)." ".trans('api.added_to_your_wallet'), 'balance' => $wallet_balance]); 
    //         } else {
    //             return redirect('wallet')->with('flash_success',symbolcurrency($request->amount,Auth::user()->country->currency_code).trans('admin.payment_msgs.amount_added'));
    //         }

    //     } catch(StripeInvalidRequestError $e) {
    //         if($request->ajax()){
    //              return response()->json(['error' => $e->getMessage()], 500);
    //         }else{
    //             return back()->with('flash_error',$e->getMessage());
    //         }
    //     } catch(Exception $e) { 
    //         if($request->ajax()) {
    //             return response()->json(['error' => $e->getMessage()], 500);
    //         } else {
    //             return back()->with('flash_error', $e->getMessage());
    //         }
    //     }
    // }

    public function add_money(Request $request)
    {
       $this->validate($request,[
        'amount'=>'required|integer',
       ]);


        $val =  number_format($request->amount, 1);
        $random_store_id = 'WAL'.rand ( 10000 , 99999 );
        $Wallet= new WalletPassbook();

        $Wallet->amount=$request->amount;
        $Wallet->user_id=$request->user_id;
        $Wallet->payment_id = $random_store_id;
        $Wallet->status='UNPAID';
        $Wallet->via= 'easypaisa';
        $Wallet->save();

        $user = User::findOrfail($request->user_id);

        $mobile = $user->mobile;
          if (strlen($mobile) == 13 && substr($mobile, 0, 3) == "+91"){
          $mobile = substr($mobile, 3, 10);
          }elseif (strlen($mobile) == 12 && substr($mobile, 0, 2) == "91"){
          $mobile = substr($mobile, 2, 10);
          }



         return view('user.api.wallet_form' , compact('val','random_store_id','user','mobile'));


    }

    public function paisa_add_money(Request $request)
    {

      try{

      if($request->success == 'true'){

         $Wallet=WalletPassbook::where('user_id',Auth::user()->id)
                      ->where('status',"UNPAID")
                      ->orderBy('created_at', 'desc')
                      ->first();
          
        
        // dd($Wallet);
        $Wallet->status="PAID";
        $Wallet->payment_id=$request->orderRefNumber;
        $Wallet->save();         

        $update_user = User::find(Auth::user()->id);
        $update_user->wallet_balance += $Wallet->amount;
        $update_user->save();
        // dd($update_user);

        (new SendPushNotification)->WalletMoney(Auth::user()->id,currency($Wallet->amount));

        $total=$update_user->wallet_balance;
               if($request->ajax()){
           return response()->json(['status'=>true,'total'=>$total,'message' => "Payment Added to Wallet Successfully!"]);
        }else{
        return redirect('wallet')->with('flash_success', 'Payment Added to Wallet Successfully!');

        } 
        }else{
          return redirect('wallet')->with('flash_error', 'Payment Not Added to Wallet Failed');
        }
       }catch (Exception $ex) {
        // dd($ex->getMessage());
         return redirect('wallet')->with('flash_error', $ex->getMessage());
      } 

      
      
      
    }


      public function api_paisa_add_money(Request $request)
    
      {

      try{

      if($request->success == 'true'){

         $Wallet=WalletPassbook::where('payment_id',$request->orderRefNumber)
                      ->where('status',"UNPAID")
                      ->orderBy('created_at', 'desc')
                      ->first();
          
        
        // dd($Wallet);
        $Wallet->status="PAID";
        $Wallet->payment_id=$request->orderRefNumber;
        $Wallet->save();         

        $update_user = User::find($Wallet->user_id);
        $update_user->wallet_balance += $Wallet->amount;
        $update_user->save();
        // dd($update_user);

        (new SendPushNotification)->WalletMoney($Wallet->user_id,currency($Wallet->amount));

        $total=$update_user->wallet_balance;
             
           return response()->json(['status'=>true,'total'=>$total,'message' => "Payment Added to Wallet Successfully!"]);
      
        }else{
          return response()->json(['status'=>false,'message'=> "Payment Not Added to Wallet Failed"]);
        }
       }catch (Exception $ex) {
        // dd($ex->getMessage());
         return response()->json(['error' => $e->getMessage()], 500);
      } 

      
      
      
    }







    public function flow_paisa_flow(Request $request)
    {
    
      try{
        // dd($request->all());

      if($request->success == 'true'){

       // dd($request->all());
         $UserRequest = UserRequests::where('booking_id',$request->orderRefNumber)->first();
// dd($UserRequest);
         $Wallet=WalletPassbook::where('user_id',Auth::user()->id)
                      ->where('status',"UNPAID")
                      ->orderBy('created_at', 'desc')
                      ->first();
          
        
        // dd($Wallet);
        $Wallet->status="PAID";
        $Wallet->payment_id=$request->orderRefNumber;
        $Wallet->save();     


        $UserRequest->paid = 1;
        $UserRequest->status = 'COMPLETED';
        $UserRequest->save();    

       
        // dd($update_user);

        if($request->ajax()) {
        return response()->json(['message' => trans('api.paid')]); 
        } else {
        return redirect('dashboard')->with('flash_success', trans('api.paid'));
        }

         
        }else{
          return redirect('dashboard')->with('flash_error', 'Easypaisa Failed to pay');
        }
       }catch (Exception $ex) {
         dd($ex->getMessage());
         return redirect('dashboard')->with('flash_error', $ex->getMessage());
      } 

      
      
      
    }






    public function paisa_payment_form(Request $request){


     

        $UserRequest = UserRequests::find($request->request_id);
        
        $tip_amount=0;

        if($UserRequest->payment_mode == 'EASYPAISA') {

            $RequestPayment = UserRequestPayment::where('request_id',$request->request_id)->first(); 
            
            if(isset($request->tips) && !empty($request->tips)){
                $tip_amount=round($request->tips,2);
            }
            
            $RequestPayment->payment_id = 0;
                    $RequestPayment->payment_mode = 'EASYPAISA';
                    $RequestPayment->payable = 0;
                    $RequestPayment->tips = $tip_amount;
                    $RequestPayment->provider_pay = $RequestPayment->provider_pay+$tip_amount;
                    $RequestPayment->save();
                    $UserRequest->save();

            
            $val =  number_format($RequestPayment->total, 1);
            $request_id = $UserRequest->booking_id;
              $Wallet= new WalletPassbook();
              $Wallet->amount=$RequestPayment->total;
              $Wallet->request_id = $request->request_id;
              $Wallet->user_id=Auth::user()->id;
              $Wallet->status='UNPAID';
              $Wallet->via= 'easypaisa';
              $Wallet->save();


         return view('user.ride.flow_form' , compact('val','request_id'));
           

        }
           
           

        }


    public function flow_verify(Request $request)
    {
          // dd($request->all());
        $paisa = $request->auth_token;
        return view('user.ride.flow_paisa' , compact('paisa'));
       
    }



    


    /**
     * send money to provider or fleet.
     *
     * @return \Illuminate\Http\Response
     */
    public function send_money(Request $request, $id){
            
        try{

            $Requests = WalletRequests::where('id',$id)->first();

            if($Requests->request_from=='provider'){
              $provider = Provider::find($Requests->from_id);
              $stripe_cust_id=$provider->stripe_cust_id;
              $email=$provider->email;
            }
            else{
              $fleet = Fleet::find($Requests->from_id);
              $stripe_cust_id=$fleet->stripe_cust_id;
              $email=$fleet->email;
            }

            if(empty($stripe_cust_id)){              
              throw new Exception(trans('admin.payment_msgs.account_not_found'));              
            }

            $StripeCharge = $Requests->amount * 100;

            Stripe::setApiKey(Setting::get('stripe_secret_key'));

            $tranfer = \Stripe\Transfer::create(array(
                     "amount" => $StripeCharge,
                     "currency" => "usd",
                     "destination" => $stripe_cust_id,
                     "description" => "Payment Settlement for ".$email                     
                 ));           

            //create the settlement transactions
            (new TripController)->settlements($id);

             $response=array();
            $response['success']=trans('admin.payment_msgs.amount_send');
           
        } catch(Exception $e) {
            $response['error']=$e->getMessage();           
        }

        return $response;
    }



    public function subscription_verify(Request $request)
    {
      $subscription = Subscriptions::findOrfail($request->subscription_id);
      
        $sub_id = 'SUB'.rand ( 10000 , 99999 );
        $subscription = provider_subscription_log::create([

        'subscription_id' => $subscription->id,
        'provider_id' => Auth::user()->id,
        'payment_id' => $sub_id,
        'status' => 'unsubscribe',

      ]);

      $val = number_format($subscription->amount,1);


      return view ('provider.payment.paisa_subscription',compact('val','sub_id'));
    }
    /**
     * Show the Payumoney payment for wallet cancel response web
     *
     * @return \Illuminate\Http\Response
     */
    public function subscription_post(Request $request)
    {   
      
     try{
            
             if($request->success == 'true'){

             $subscription_check = provider_subscription_log::where('provider_id',Auth::user()->id)->where('payment_id',$request->orderRefNum)->first();

              $subscription_check->status = 'subscribe';
              $subscription_check->save();

               $subscription = Subscriptions::findOrfail($subscription_check->subscription_id);


         
         
            //sending push on adding wallet money
            (new SendPushNotification)->SubscriptionProvider(Auth::user()->id,currency($subscription->amount));

            $start = \Carbon\Carbon::now(); 
            $start_at = \Carbon\Carbon::now(); 
            $ended_at = $start_at->addDays($subscription->no_of_days); 

            $insert = new SubscriptionHistories; 
            $insert->subscription_id = $subscription->id;  
            $insert->provider_id = Auth::user()->id;  
            $insert->status = 'Active';   
            $insert->started_at = date('Y-m-d 00:00:00',strtotime($start));   
            $insert->ended_at = date('Y-m-d 23:59:59',strtotime($ended_at));   
            $insert->save(); 

            $provider = Auth::user();
            $provider->subscribe = 'subscribed';
            $provider->save();

            // //for create the user wallet transaction
            // (new TripController)->userCreditDebit($request->amount,Auth::user()->id,1); 

            if($request->ajax()){
                return response()->json(['success' => trans('api.push.subscribed'), 'message' => trans('api.subscribed'),'subscription_history' =>$insert]); 
            } else {
                return redirect('provider')->with('flash_success',trans('api.push.subscribed'));
            }
          }else{

               return redirect('provider')->with('flash_error',trans('Easypaisa failed to subscribe'));
          }
        } catch(StripeInvalidRequestError $e) {
        
            if($request->ajax()){
                 return response()->json(['error' => $e->getMessage()], 500);
            }else{
                return back()->with('flash_error',$e->getMessage());
            }
        } catch(Exception $e) {
        
            if($request->ajax()) {
                return response()->json(['error' => $e->getMessage()], 500);
            } else {
                return redirect('provider')->with('flash_error',trans('Easypaisa failed to subscribe'));
            }
        }
  
    }

    public function easyPay(Request $request) {
        return view('user.account.easypay');
    }


    public function api_wallet_verify(Request $request)
    {
         // dd($request->all());
        $paisa = $request->auth_token;
        return view('user.api.paisa' , compact('paisa'));
       
    }

      public function api_flow_verify(Request $request)
    {
         // dd($request->all());
        $paisa = $request->auth_token;
        return view('user.api.flow_paisa' , compact('paisa'));
       
    }



public function api_paisa_payment_form(Request $request){


     $UserRequest = UserRequests::find($request->request_id);
        
        $tip_amount= 0;

        if($UserRequest->payment_mode == 'EASYPAISA') {

            $RequestPayment = UserRequestPayment::where('request_id',$request->request_id)->first(); 
            
            if(isset($request->tips) && !empty($request->tips)){
                $tip_amount=round($request->tips,2);
            }
            
            $RequestPayment->payment_id = 0;
                    $RequestPayment->payment_mode = 'EASYPAISA';
                    $RequestPayment->payable = 0;
                    $RequestPayment->tips = $tip_amount;
                    $RequestPayment->provider_pay = $RequestPayment->provider_pay+$tip_amount;
                    $RequestPayment->save();
                    $UserRequest->save();

            
            $val =  number_format($RequestPayment->total, 1);
            $request_id = $UserRequest->booking_id;
              $Wallet= new WalletPassbook();
              $Wallet->amount=$RequestPayment->total;
              $Wallet->request_id = $request->request_id;
              $Wallet->payment_id = $UserRequest->booking_id;
              $Wallet->user_id=$request->user_id;
              $Wallet->status='UNPAID';
              $Wallet->via= 'easypaisa';
              $Wallet->save();

            $user = User::findOrfail($UserRequest->user_id);
              $mobile = $user->mobile;
                if (strlen($mobile) == 13 && substr($mobile, 0, 3) == "+91"){
                 $mobile = substr($mobile, 3, 10);
                }elseif (strlen($mobile) == 12 && substr($mobile, 0, 2) == "91"){
                 $mobile = substr($mobile, 2, 10);
                }


         return view('user.api.flow_form' , compact('val','request_id','user','mobile'));
           

        }
}



  public function flow_api_paisa_flow(Request $request)
  {
    
    try{
        // dd($request->all());

      if($request->success == 'true'){
          $UserRequest = UserRequests::where('booking_id',$request->orderRefNumber)->first();
          $Wallet=WalletPassbook::where('payment_id',$UserRequest->booking_id)
                      ->where('status',"UNPAID")
                      ->orderBy('created_at', 'desc')
                      ->first();
          $Wallet->status="PAID";
          $Wallet->save();     


          $UserRequest->paid = 1;
          $UserRequest->status = 'COMPLETED';
          $UserRequest->save();    

        return response()->json(['status'=>true,'total'=>$UserRequest->total,'message' => "Payment Paid Successfully"]);

        }else{
         
          return response()->json(['status'=>false,'message'=> "Payment Failed"]);
        }
       }catch (Exception $e) {
         return response()->json(['error' => $e->getMessage()], 500);

      } 
    }



  public function api_subscription_verify(Request $request)
    {

      $subscription = Subscriptions::findOrfail($request->subscription_id);
      $sub_id = 'SUB'.rand ( 10000 , 99999 );
      $val = number_format($subscription->amount,1);
      $subscription_log = provider_subscription_log::create([

        'subscription_id' => $subscription->id,
        'provider_id' => $request->provider_id,
        'payment_id' => $sub_id,
        'status' => 'unsubscribe',

      ]);


      $provider = Provider::findOrfail($request->provider_id);

        $mobile = $provider->mobile;

          if (strlen($mobile) == 13 && substr($mobile, 0, 3) == "+91"){
           $mobile = substr($mobile, 3, 10);
          }elseif (strlen($mobile) == 12 && substr($mobile, 0, 2) == "91"){
           $mobile = substr($mobile, 2, 10);
          }


      return view ('provider.api.subscription',compact('val','sub_id','provider','mobile'));
  }



  public function api_provider_verify(Request $request)
    {
      try{
         $paisa = $request->auth_token;
       
        return view('provider.api.paisa' , compact('paisa'));
    
    }catch(Exception $e){

        return response()->json(['status'=>false,'message'=> "Easypaisa failed to subscribe"]);
    }


    }




   public function api_subscription_post(Request $request)
    {   
      
     try{
            
             if($request->success == 'true'){

              $subscription_check = provider_subscription_log::where('payment_id',$request->orderRefNumber)->first();

              $subscription_check->status = 'subscribe';
              $subscription_check->save();

               $subscription = Subscriptions::findOrfail($subscription_check->subscription_id);


         
         
            //sending push on adding wallet money
            (new SendPushNotification)->SubscriptionProvider(Auth::user()->id,currency($subscription->amount));

            $start = \Carbon\Carbon::now(); 
            $start_at = \Carbon\Carbon::now(); 
            $ended_at = $start_at->addDays($subscription->no_of_days); 

            $insert = new SubscriptionHistories; 
            $insert->subscription_id = $subscription->id;  
            $insert->provider_id = $subscription_check->provider_id;  
            $insert->status = 'Active';   
            $insert->started_at = date('Y-m-d 00:00:00',strtotime($start));   
            $insert->ended_at = date('Y-m-d 23:59:59',strtotime($ended_at));   
            $insert->save(); 

            $provider = Provider::findOrfail($subscription_check->provider_id);
            $provider->subscribe = 'subscribed';
            $provider->save();

            // //for create the user wallet transaction
            // (new TripController)->userCreditDebit($request->amount,Auth::user()->id,1); 
          return response()->json(['success' => trans('api.push.subscribed'), 'message' => trans('api.subscribed'),'subscription_history' =>$insert]); 
        }else{
                 return response()->json(['error' => 'Easypaisa failed to subscribe']); 
              
          }
        }catch(StripeInvalidRequestError $e) {
          return response()->json(['error' => $e->getMessage()], 500);
        }catch(Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
           
        }
  
    }

           
     
     
}
