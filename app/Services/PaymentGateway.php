<?php 

namespace App\Services;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Validator;
use Exception;
use DateTime;
use Auth;
use Lang;
use Setting;
use App\ServiceType;
use App\Promocode;
use App\Provider;
use App\ProviderService;
use App\Helpers\Helper;
use GuzzleHttp\Client;
use App\PaymentLog;


//PayuMoney
use Tzsk\Payu\Facade\Payment AS PayuPayment;

//Paypal
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer; 
use PayPal\Api\Payee;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

use Redirect;
use Session;
use URL;




class PaymentGateway {

	private $gateway;

	public function __construct($gateway){
		$this->gateway = strtoupper($gateway);
	}

	public function process($attributes) {


		$provider_url = '';

		$gateway = ($this->gateway == 'STRIPE') ? 'CARD' : $this->gateway ;
		switch ($this->gateway) {

			case "BRAINTREE":

				(new \App\Http\Controllers\UserApiController())->set_Braintree();
				$result = \Braintree_Transaction::sale([
                  'amount' => $attributes['amount'],
                  'paymentMethodNonce' => $attributes['nonce'],
                  'orderId' => $attributes['order'],                  
                  'customFields' =>[
                  	'request_id' => $attributes['request_id'],
                  	'wallettransaction'=>$attributes['wallettransaction'],
                  	'tips'=>$attributes['tips']
                  ],                
                  'options' => [
                      'submitForSettlement' => True,
                      'paypal' => [
                      	
                    ],
                  ],
                ]); 
                $UserID = Auth::user()->id;

                \Log::info($result);
                
                if($result->success == true) {
					return redirect($provider_url.'/payment/response?order='. $attributes['order'] .'&pay='. $result->transaction->id.'&request_id='. $attributes['request_id'].'&wallettransaction='. $attributes['wallettransaction'].'&UserID='. $UserID.'&tips='. $attributes['tips']);
				} else {
					return redirect($provider_url.'/payment/failure?order='. $attributes['order']);
				}
				
				break;

			

        		return $payment->receive();

				break;

			default:
				return redirect('dashboard');
		}
		

	}
	
}