@extends('user.layout.base')

@section('title', 'Wallet ')

@section('content')



<div class="col-md-9">
    <div class="dash-content">
        <div class="row no-margin">
            <div class="col-md-12">
                <h4 class="page-title">@lang('user.my_wallet')</h4>
            </div>
        </div>
        @include('common.notify')

        <div class="row no-margin">
             <form action="{{url('/paisa_wallet')}}" method="POST" id="easyPayStartForm">

            {{ csrf_field() }}
                <div class="col-md-6">
                     
                    <div class="wallet">
                        <h4 class="amount">
                            <span class="price">{{currency(Auth::user()->wallet_balance)}}</span>
                            <span class="txt">@lang('user.in_your_wallet')</span>
                        </h4>
                    </div>                                                               

                </div>
          
                <div class="col-md-6">
                    
                    <h6><strong>@lang('user.add_money')</strong></h6>

                    <div class="input-group full-input">
                        <input type="number" class="form-control" id="amount" name="amount" placeholder="Enter Amount" >
                    </div>

                
                    <br>
                     <div class="input-group full-input">
                        <select class="form-control" id="payment_mode" name="payment_mode">
                              @if(Setting::get('EASYPAISA') == 1)
                            <option value="EASYPAISA">EASYPAISA</option>
                              @endif
                            
                        </select>
                    </div>
                    

                   
                      

            <div class="row no-margin easy_paisa">
               
                
                       <button type="submit" class="full-primary-btn fare-btn">@lang('user.add_money') </button>
                </form>
            </div>
                
                   </div>
                </div>
            
            </form>
        </div>

    </div>
</div>

@endsection

@section('scripts')

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>


  <script type="text/javascript">
    $( document ).ready(function() {
        var paymentmode = $("#payment_mode").val();
         $("#pay_but_mode").hide();
        if(paymentmode =="")
        {
            $("#card_mode").hide();
            $(".easy_paisa").hide();
           

        }

        $("#amount").Onchange(function(){
           
       
        });
    });

    </script>


@endsection