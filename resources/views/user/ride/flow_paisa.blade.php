@extends('user.layout.base')

@section('title', 'Dashboard ')

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
<div class="clear"></div>
      <div align="center">
     <div class="loader"></div>
      </div>
<form action="https://easypay.easypaisa.com.pk/easypay/Confirm.jsf" method="POST" id="easyPayAuthForm">
<input name="auth_token" value="{{$paisa}}" hidden = "true"/>
<input name="postBackURL" value="https://www.kangarooapp.com.pk/confirmflowpay" hidden = "true"/>
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

@endsection