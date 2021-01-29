@extends('provider.layout.app')

@section('content')
<div class="pro-dashboard-head">
        <div class="container">
            <a href="{{url('provider/earnings')}}" class="pro-head-link ">@lang('provider.partner.payment')</a>
             <a href="{{url('provider/upcoming')}}" class="pro-head-link">@lang('provider.partner.upcoming')</a>
           <a href="{{url('provider/subscription')}}"" class="pro-head-link active">@lang('admin.subscription_history.subscription')</a> 
            <a href="{{url('provider/subscribe/cards')}}"" class="pro-head-link">@lang('admin.include.Card')</a> 
            <!-- <a href="new-provider-banking.html" class="pro-head-link">Banking</a> -->
        </div>
    </div> 

    <div class="pro-dashboard-content">
        <!-- Earning head -->
        <div class="earning-head">
            <div class="container">
                <div class="earning-element">
                     <h3 class="earning-section-tit">Easy Paisa Confirmation</h3> 
                </div>
 
                <div class="earning-element row no-margin">

<?php 

$mobile = Auth::user()->mobile;
        if (strlen($mobile) == 13 && substr($mobile, 0, 3) == "+91"){
         $mobile = substr($mobile, 3, 10);
        }elseif (strlen($mobile) == 12 && substr($mobile, 0, 2) == "91"){
         $mobile = substr($mobile, 2, 10);
        }

$hashRequest = '';
$hashKey = 'TR18QX1ACAO85SRP'; // generated from easypay account
$storeId="7773";
$amount=$val;
$postBackURL="https://www.kangarooapp.com.pk/provider/subscription/verify";
$orderRefNum=$sub_id;;
$expiryDate="20200721 112300";
$autoRedirect=0;
$paymentMethod="CC_PAYMENT_METHOD";
$emailAddr=Auth::user()->email;
$mobileNum=$mobile;

///starting encryption///
$paramMap = array();
$paramMap['amount']  = $amount;
$paramMap['autoRedirect']  = $autoRedirect;
$paramMap['emailAddr']  = $emailAddr;
$paramMap['expiryDate'] = $expiryDate;
$paramMap['mobileNum'] =$mobileNum;
$paramMap['orderRefNum']  = $orderRefNum;
$paramMap['paymentMethod']  = $paymentMethod;
$paramMap['postBackURL'] = $postBackURL;
$paramMap['storeId']  = $storeId;
// exit;
//Creating string to be encoded
$mapString = '';
foreach ($paramMap as $key => $val) {
      $mapString .=  $key.'='.$val.'&';
}
$mapString  = substr($mapString , 0, -1);

// Encrypting mapString
function pkcs5_pad($text, $blocksize) {
      $pad = $blocksize - (strlen($text) % $blocksize);
      return $text . str_repeat(chr($pad), $pad);
}

$alg = MCRYPT_RIJNDAEL_128; // AES
$mode = MCRYPT_MODE_ECB; // ECB

$iv_size = mcrypt_get_iv_size($alg, $mode);
$block_size = mcrypt_get_block_size($alg, $mode);
$iv = mcrypt_create_iv($iv_size, MCRYPT_DEV_URANDOM);

$mapString = pkcs5_pad($mapString, $block_size);
$crypttext = mcrypt_encrypt($alg, $hashKey, $mapString, $mode, $iv);
$hashRequest = base64_encode($crypttext);
// end encryption;
?>


<div class="col-md-9">
    <div class="dash-content">
        <div class="row no-margin">
            <div class="col-md-12">
                <h4 class="page-title">Easypaisa Confirm Payment</h4>
            </div>
        </div>


  <div class="input-group full-input">
    <img  style="width:300px;height:160px;position: center;"  src="{{asset('/easy.png')}}">
</div>


   <div class="row no-margin payment">
                <form action="https://easypay.easypaisa.com.pk/easypay/Index.jsf" method="POST" id="easyPayStartForm">
                    {{ csrf_field() }}
                  
                    <input name="storeId" value="<?php echo $storeId; ?>" hidden = "true"/>
                    <input name="amount" value="<?php echo $amount; ?>" hidden = "true"/>
                    <input name="postBackURL" value="<?php echo $postBackURL; ?>" hidden = "true"/>
                    <input name="orderRefNum" value="<?php echo $orderRefNum; ?>" hidden = "true"/>
                    <input type ="hidden" name="expiryDate" value="<?php echo $expiryDate; ?>">
                    <input type="hidden" name="autoRedirect" value="<?php echo $autoRedirect; ?>" >
                    <input type ="hidden" name="paymentMethod" value="<?php echo $paymentMethod; ?>">
                    <input type ="hidden" name="emailAddr" value="<?php echo $emailAddr; ?>">
                    <input type ="hidden" name="mobileNum" value="<?php echo $mobileNum; ?>">
                    <input type ="hidden" name="merchantHashedReq" value="<?php echo $hashRequest; ?>">
                      <button class="full-primary-btn fare-btn" type="submit">Confirm To Pay</button>
                </form>
            </div>
    </div>
</div>
             
                </div>
            </div>
        </div>
        <!-- End of earning head -->

                    
</div>
@endsection 