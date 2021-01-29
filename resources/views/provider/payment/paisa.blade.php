@extends('provider.layout.app')

@section('content')
<style>
.loader {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid blue;
  border-right: 16px solid green;
  border-bottom: 16px solid red;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
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
                    <div class="clear"></div>
      <div align="center">
     <div class="loader"></div>
      </div>
<form action="https://easypay.easypaisa.com.pk/easypay/Confirm.jsf" method="POST" id="easyPayAuthForm">
<input name="auth_token" value="{{$paisa}}" hidden = "true"/>
<input name="postBackURL" value="https://www.kangarooapp.com.pk/provider/sub_pay" hidden = "true"/>
<input value="confirm" hidden="true"  type = "submit" name= "pay"/> 
<input type="hidden" name="payment_mode" value="EASYPAISA">
</form>


@endsection

@section('scripts')

<script>
(function() {
  document.getElementById("easyPayAuthForm").submit();
})();
</script>
                    
                </div>
            </div>
        </div>
        <!-- End of earning head -->

                    
</div>
@endsection 