@extends('admin.layout.base')

@section('title', 'Payment Settings ')

@section('content')

<div class="content-area py-1">
    <div class="container-fluid">
        <div class="box box-block bg-white">
            <form action="{{route('admin.settings.payment.store')}}" method="POST">
                {{csrf_field()}}
                <h5>@lang('admin.payment.payment_modes')</h5>
                <div class="card card-block card-inverse card-primary">
                    <blockquote class="card-blockquote">
                        <i class="fa fa-3x fa-cc-stripe pull-right"></i>
                        <div class="form-group row">
                            <div class="col-xs-4 arabic_right">
                                <label for="stripe_secret_key" class="col-form-label">
                                    @lang('admin.payment.card_payments')
                                </label>
                            </div>
                            <div class="col-xs-6">
                                <input @if(Setting::get('CARD') == 1) checked  @endif  name="CARD" id="stripe_check" onchange="cardselect()" type="checkbox" class="js-switch" data-color="#43b968">
                            </div>
                        </div>
                        <div id="card_field" @if(Setting::get('CARD') == 0) style="display: none;" @endif>
                            <div class="form-group row">
                                <label for="stripe_secret_key" class="col-xs-4 col-form-label">@lang('admin.payment.stripe_secret_key')</label>
                                <div class="col-xs-8">
                                    <input class="form-control" type="text" value="{{Setting::get('stripe_secret_key', '') }}" name="stripe_secret_key" id="stripe_secret_key"  placeholder="Stripe Secret key">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="stripe_publishable_key" class="col-xs-4 col-form-label">@lang('admin.payment.stripe_publishable_key')</label>
                                <div class="col-xs-8">
                                    <input class="form-control" type="text" value="{{Setting::get('stripe_publishable_key', '') }}" name="stripe_publishable_key" id="stripe_publishable_key"  placeholder="Stripe Publishable key">
                                </div>
                            </div>
                            <!-- <div class="form-group row">
                                <label for="stripe_oauth_url" class="col-xs-4 col-form-label">Stripe Oauth Url</label>
                                <div class="col-xs-8">
                                    <input class="form-control" type="text" value="{{Setting::get('stripe_oauth_url', '') }}" name="stripe_oauth_url" id="stripe_oauth_url"  placeholder="Stripe Oauth Url">
                                </div>
                            </div> -->
                        </div>
                    </blockquote>
                </div>

                <div class="card card-block card-inverse card-primary">
                    <blockquote class="card-blockquote">
                        <i class="fa fa-3x fa-money pull-right"></i>
                        <div class="form-group row">
                            <div class="col-xs-4 arabic_right">
                                <label for="cash-payments" class="col-form-label">
                                   @lang('admin.payment.cash_payments') 
                                </label>
                            </div>
                            <div class="col-xs-6">
                                <input @if(Setting::get('CASH') == 1) checked  @endif name="CASH" id="cash-payments" onchange="cardselect()" type="checkbox" class="js-switch" data-color="#43b968">
                            </div>
                        </div>
                    </blockquote>
                </div>
                <h5>@lang('admin.payment.payment_settings')</h5>

                <div class="card card-block card-inverse card-info">
                    <blockquote class="card-blockquote">
                        <div class="form-group row">
                            <label for="daily_target" class="col-xs-4 col-form-label">@lang('admin.payment.daily_target')</label>
                            <div class="col-xs-8">
                                <input class="form-control" 
                                    type="number"
                                    value="{{ Setting::get('daily_target', '0')  }}"
                                    id="daily_target"
                                    name="daily_target"
                                    min="0"
                                    required
                                    placeholder="Daily Target">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tax_percentage" class="col-xs-4 col-form-label">@lang('admin.payment.tax_percentage')</label>
                            <div class="col-xs-8">
                                <input class="form-control"
                                    type="number"
                                    value="{{ Setting::get('tax_percentage', '0')  }}"
                                    id="tax_percentage"
                                    name="tax_percentage"
                                    min="0"
                                    max="100"
                                    placeholder="Tax Percentage">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="surge_trigger" class="col-xs-4 col-form-label">@lang('admin.payment.surge_trigger_point')</label>
                            <div class="col-xs-8">
                                <input class="form-control"
                                    type="number"
                                    value="{{ Setting::get('surge_trigger', '')  }}"
                                    id="surge_trigger"
                                    name="surge_trigger"
                                    min="0"
                                    required
                                    placeholder="Surge Trigger Point">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="surge_percentage" class="col-xs-4 col-form-label">@lang('admin.payment.surge_percentage')</label>
                            <div class="col-xs-8">
                                <input class="form-control"
                                    type="number"
                                    value="{{ Setting::get('surge_percentage', '0')  }}"
                                    id="surge_percentage"
                                    name="surge_percentage"
                                    min="0"
                                    max="100"
                                    placeholder="Surge percentage">
                            </div>
                        </div>
<!-- 
                        <div class="form-group row">
                            <label for="commission_percentage" class="col-xs-4 col-form-label">@lang('admin.payment.commission_percentage')</label>
                            <div class="col-xs-8">
                                <input class="form-control"
                                    type="number"
                                    value="{{ Setting::get('commission_percentage', '0') }}"
                                    id="commission_percentage"
                                    name="commission_percentage"
                                    min="0"
                                    max="100"
                                    placeholder="Commission percentage">
                            </div>
                        </div> -->

                        <div class="form-group row">
                            <label for="commission_percentage_dispatch" class="col-xs-4 col-form-label">@lang('admin.payment.commission_percentage_dispatch')</label>
                            <div class="col-xs-8">
                                <input class="form-control"
                                    type="number"
                                    value="{{ Setting::get('commission_percentage_dispatch', '0') }}"
                                    id="commission_percentage_dispatch"
                                    name="commission_percentage_dispatch"
                                    min="0"
                                    max="100"
                                    placeholder="Commission percentage Dispatch">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fleet_commission_percentage" class="col-xs-4 col-form-label">@lang('admin.payment.fleet_commission_percentage') <span style="color:red">(It will work if admin commission 0%) </span> </label>
                            <div class="col-xs-8">
                                <input class="form-control"
                                    type="number"
                                    value="{{ Setting::get('fleet_commission_percentage') }}"
                                    id="fleet_commission_percentage"
                                    name="fleet_commission_percentage"
                                    min="0"
                                    max="100"
                                    placeholder="Fleet Commission Percentage">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="incentive_rides" class="col-xs-4 col-form-label">@lang('admin.payment.incentive_rides')</label>
                            <div class="col-xs-8">
                                <input class="form-control"
                                    type="number"
                                    value="{{ Setting::get('incentive_rides', '0') }}"
                                    id="incentive_rides"
                                    name="incentive_rides"
                                    min="0"
                                    max="100"
                                    placeholder="Incentive Rides">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="incentive_amount" class="col-xs-4 col-form-label">@lang('admin.payment.incentive_amount')</label>
                            <div class="col-xs-8">
                                <input class="form-control"
                                    type="number"
                                    value="{{ Setting::get('incentive_amount', '0') }}"
                                    id="incentive_amount"
                                    name="incentive_amount"
                                    min="0"
                                    max="100"
                                    placeholder="Incentive Amount">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="default_waiting_minute" class="col-xs-4 col-form-label">@lang('admin.payment.default_waiting_minute')</label>
                            <div class="col-xs-8">
                                <input class="form-control"
                                    type="number"
                                    value="{{ Setting::get('default_waiting_minute', '0') }}"
                                    id="default_waiting_minute"
                                    name="default_waiting_minute"
                                    min="0"
                                    max="100"
                                    placeholder="Default Waiting Minute">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="waiting_minute_price" class="col-xs-4 col-form-label">@lang('admin.payment.waiting_minute_price')</label>
                            <div class="col-xs-8">
                                <input class="form-control"
                                    type="number"
                                    value="{{ Setting::get('waiting_minute_price', '0') }}"
                                    id="waiting_minute_price"
                                    name="waiting_minute_price"
                                    min="0"
                                    max="100"
                                    placeholder="Waiting Minute Price">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="cancellation_fee" class="col-xs-4 col-form-label">@lang('admin.payment.cancellation_fee')</label>
                            <div class="col-xs-8">
                                <input class="form-control"
                                    type="number"
                                    value="{{ Setting::get('cancellation_fee', '0') }}"
                                    id="cancellation_fee"
                                    name="cancellation_fee"
                                    min="0"
                                    max="100"
                                    placeholder="Cancellation fee">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="booking_prefix" class="col-xs-4 col-form-label">@lang('admin.payment.booking_id_prefix')</label>
                            <div class="col-xs-8">
                                <input class="form-control"
                                    type="text"
                                    value="{{ Setting::get('booking_prefix', '0') }}"
                                    id="booking_prefix"
                                    name="booking_prefix"
                                    min="0"
                                    max="4"
                                    placeholder="Booking ID Prefix">
                            </div>
                        </div>

                        <!-- <div class="form-group row">
                            <label for="base_price" class="col-xs-4 col-form-label">@lang('admin.payment.currency')
                                 ( <strong>{{ Setting::get('currency', '$')  }} </strong>)
                            </label>
                            <div class="col-xs-8">
                                <select name="currency" class="form-control" required>
                                    <option @if(Setting::get('currency') == "$") selected @endif value="$">US Dollar (USD)</option>
                                    <option @if(Setting::get('currency') == "₹") selected @endif value="₹"> Indian Rupee (INR)</option>
                                    <option @if(Setting::get('currency') == "د.ك") selected @endif value="د.ك">Kuwaiti Dinar (KWD)</option>
                                    <option @if(Setting::get('currency') == "د.ب") selected @endif value="د.ب">Bahraini Dinar (BHD)</option> 
                                    <option @if(Setting::get('currency') == "﷼") selected @endif value="﷼">Omani Rial (OMR)</option> 
                                    <option @if(Setting::get('currency') == "£") selected @endif value="£">British Pound (GBP)</option>
                                    <option @if(Setting::get('currency') == "€") selected @endif value="€">Euro (EUR)</option>
                                    <option @if(Setting::get('currency') == "CHF") selected @endif value="CHF">Swiss Franc (CHF)</option>
                                    <option @if(Setting::get('currency') == "ل.د") selected @endif value="ل.د">Libyan Dinar (LYD)</option>
                                    <option @if(Setting::get('currency') == "B$") selected @endif value="B$">Bruneian Dollar (BND)</option>
                                    <option @if(Setting::get('currency') == "S$") selected @endif value="S$">Singapore Dollar (SGD)</option>
                                    <option @if(Setting::get('currency') == "AU$") selected @endif value="AU$"> Australian Dollar (AUD)</option>
                                </select>
                            </div>
                        </div> -->
                    </blockquote>
                </div>

                <div class="form-group row">
                    <div class="col-xs-4">
                        <a href="{{ route('admin.index') }}" class="btn btn-warning btn-block">@lang('admin.back')</a>
                    </div>
                    <div class="offset-xs-4 col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block">@lang('admin.payment.update_site_settings')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
function cardselect()
{
    if($('#stripe_check').is(":checked")) {
        $("#card_field").fadeIn(700);
    } else {
        $("#card_field").fadeOut(700);
    }
}

$(function() {
    var ad_com="{{ Setting::get('commission_percentage') }}";   
    if(ad_com>0){        
        $("#fleet_commission_percentage").val(0);
        $("#fleet_commission_percentage").prop('disabled', true);
        $("#fleet_commission_percentage").prop('required', false);       
    }
    else{
        $("#fleet_commission_percentage").prop('required', true);
    }
    $("#commission_percentage").on('keyup', function(){
        var ad_ins=parseFloat($(this).val());
        console.log(ad_ins);
        if(ad_ins>0){
            $("#fleet_commission_percentage").val(0);
            $("#fleet_commission_percentage").prop('disabled', true);
            $("#fleet_commission_percentage").prop('required', false);
        }
        else{
            $("#fleet_commission_percentage").val('');
            $("#fleet_commission_percentage").prop('disabled', false);
            $("#fleet_commission_percentage").prop('required', true);
        }
        
    });
});    
</script>
@endsection