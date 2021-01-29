@extends('user.layout.base')

@section('title', 'Payment')

@section('content')

<div class="col-md-9">
    <div class="dash-content">
    <form action=" https://easypay.easypaisa.com.pk/easypay/Confirm.jsf " method="POST" target="_blank">
        <input name="auth_token" value="<?php echo $_GET['auth_token'] ?>" hidden = "true"/>
        <input name="postBackURL" value="http://www.my.online-store.com/transaction/MessageHandler1" hidden =
        "true"/>
        <input value="confirm" type = "submit" name= "pay"/>
    </form>
    </div>
</div>
