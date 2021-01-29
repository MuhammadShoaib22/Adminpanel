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
                     <h3 class="earning-section-tit">@lang('admin.subscription_history.subscription')</h3> 
                </div>
                <div class="earning-element row no-margin">

                @foreach($subscriptions as $subscription)
                    <div class="col-lg-2 col-md-3 col-sm-3 col-xs-4">
                        <div class="earning-box">
                            <a href="#" data-toggle="modal" data-target="#myModal{{$subscription->id}}"><p class="dashboard-count" style="text-align: center;"><img src="{{url('/storage',$subscription->image)}}" width="75%"></p>
                            <p class="dashboard-txt" style="text-align: center;">{{$subscription->name}}</p></a>
                        </div>
                    </div>  
                    <div class="modal fade" id="myModal{{$subscription->id}}">
                        <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                           <!-- Modal Header -->
                            <div class="modal-header"> 
                              <button type="button" class="close" data-dismiss="modal">&times;</button><br>
                            </div>
                            <!-- Modal body -->
                            <div class="modal-body">
                              <h3>Subscription Details</h3><br>
                              <p>Name : <strong>{{$subscription->name}}</strong></p>
                              <p>Amount : <strong>{{$subscription->amount}}</strong></p> 
                              <p>No Of Days : <strong>{{$subscription->no_of_days}}</strong></p>  
                            </div>
                            
                            <!-- Modal footer -->
                            <div class="modal-footer">
                                @if($subscription_active) 
                                   <button type="submit" class="btn btn-info" style="color: black">Already Subscribed - {{$subscription_active->subscription->name}}</button> 
                               
                                @else 
                                    <form action="{{ url('provider/subscription') }}" method="POST" >
                                        {{ csrf_field() }}
                                        <input type="hidden" name="subscription_id" value="{{$subscription->id}}">
                                        <select name="card_id" class="form-control" required="">
                                      
                                       
                                        <option value="EASYPAISA">EASYPAISA</option> 
                                       
                                        </select><br>
                                        <button type="submit" class="btn btn-primary" style="color: black">Subscribe</button>
                                    </form>
                                @endif
                            </div>
                            
                          </div>
                        </div>
                      </div>
                @endforeach   
                </div>
            </div>
        </div>
        <!-- End of earning head -->

        <!-- Earning Content -->
        <div class="earning-content gray-bg">
            <div class="container">

                <!-- Earning section -->
                <div class="earning-section pad20 row no-margin">
                    <div class="earning-section-head">
                        <h3 class="earning-section-tit">@lang('admin.subscription_history.currently_active')</h3>
                    </div>

                    <!-- Earning acc-wrapper -->
                    <div class="col-lg-7 col-md-8 col-sm-10 col-xs-12 no-padding"">
                        <div class="earn-acc-wrapper"> 
                            <div class="earning-acc pad20">
                                @if($subscription_active)
                                <div class="row no-margin">
                                    <div class="pull-left trip-left">
                                        <h3 class="acc-tit estimate-tit">
                                            @lang('admin.subscription_history.name')
                                        </h3>
                                    </div>

                                    <div class="pull-right trip-right">
                                        <p class="earning-cost no-margin">{{$subscription_active->subscription->name}}</p>
                                    </div>
                                </div>
                                <div class="earning-acc pad20"></div>
                                <div class="row no-margin">
                                    <div class="pull-left trip-left">
                                        <h3 class="acc-tit estimate-tit">
                                            @lang('admin.subscription_history.amount')
                                        </h3>
                                    </div>

                                    <div class="pull-right trip-right">
                                        <p class="earning-cost no-margin">{{$subscription_active->subscription->amount}}</p>
                                    </div>
                                </div>
                                <div class="earning-acc pad20"></div> 
                                <div class="row no-margin">
                                    <div class="pull-left trip-left">
                                        <h3 class="acc-tit estimate-tit">
                                            @lang('admin.subscription_history.remaining_days')
                                        </h3>
                                    </div>
                                    <?php 
                                    $today=\Carbon\Carbon::now();
                                    $ended_at=\Carbon\Carbon::parse($subscription_active->ended_at);
                                    $diff = date_diff($today,$ended_at); 
                                     ?>
                                    <div class="pull-right trip-right">
                                        <p class="earning-cost no-margin">{{($diff->d==1)? $diff->d.' Day' : $diff->d.' Days'}} </p>
                                    </div>
                                </div>
                                <div class="earning-acc pad20"></div>
                                <div class="row no-margin">
                                    <div class="pull-left trip-left">
                                        <h3 class="acc-tit estimate-tit">
                                            @lang('admin.subscription_history.started_at')
                                        </h3>
                                    </div>

                                    <div class="pull-right trip-right">
                                        <p class="earning-cost no-margin">{{date('Y D, M d',strtotime($subscription_active->started_at))}}</p>
                                    </div>
                                </div>
                                <div class="earning-acc pad20"></div>
                                <div class="row no-margin">
                                    <div class="pull-left trip-left">
                                        <h3 class="acc-tit estimate-tit">
                                            @lang('admin.subscription_history.expired_at')
                                        </h3>
                                    </div>

                                    <div class="pull-right trip-right">
                                        <p class="earning-cost no-margin">{{date('Y D, M d',strtotime($subscription_active->ended_at))}}</p>
                                    </div>
                                </div>
                                <div class="earning-acc pad20"></div>
                                <div class="row no-margin">
                                    <div class="pull-left trip-left">
                                        <h3 class="acc-tit estimate-tit">
                                            @lang('admin.subscription_history.Status')
                                        </h3>
                                    </div>

                                    <div class="pull-right trip-right">
                                        <p class="earning-cost no-margin">{{strtoupper($subscription_active->status)}}</p>
                                    </div>
                                </div>
                                @else
                                <div class="row no-margin">
                                    <div class="pull-left trip-left">
                                        <h3 class="acc-tit estimate-tit">
                                            No Subscription Package..
                                        </h3>
                                    </div> 
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- End of earning acc-wrapper -->
                </div>
                <!-- End of earning section -->

                <!-- Earning section -->
                <div class="earning-section earn-main-sec pad20">
                    <!-- Earning section head -->
                    <div class="earning-section-head row no-margin">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 no-left-padding">
                            <h3 class="earning-section-tit">@lang('admin.subscription_history.subscrption_histories')</h3>
                        </div>
                       {{--<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12"> 
                            <div class="daily-earn-right text-right">
                                <div class="status-block display-inline row no-margin">
                                    <form class="form-inline status-form">
                                        <div class="form-group">
                                            <label>@lang('provider.partner.status')</label>
                                            <select type="password" class="form-control mx-sm-3">
                                                <option>@lang('provider.partner.all_trip')</option>
                                                <option>@lang('provider.partner.completed')</option>
                                                <option>@lang('provider.partner.pending')</option>
                                            </select>
                                        </div>
                                    </form>
                                </div>
                                <!-- View tab -->

                                <!-- End of view tab -->
                            </div>
                        </div>--}}
                    </div> 
                    <!-- End of earning section head -->

                    <!-- Earning-section content -->
                    <div class="tab-content list-content">
                        <div class="list-view pad30 ">

                            <table class="earning-table table table-responsive" id="myTable">
                                <thead>
                                    <tr>
                                        <th>@lang('admin.subscription_history.name')</th>
                                        <th>@lang('admin.subscription_history.amount')</th>
                                        <th>@lang('admin.subscription_history.no_of_days')</th>
                                        <th>@lang('admin.subscription_history.started_at')</th>
                                        <th>@lang('admin.subscription_history.expired_at')</th>
                                        <th>@lang('admin.subscription_history.Status')</th> 
                                    </tr>
                                </thead>
                                <tbody> 
                                @foreach($subscription_histories as $each)
                                    <tr> 
                                        <td>{{ @$each->subscription->name }}</td>
                                        <td>{{ @$each->subscription->amount }}</td>
                                        <td>{{ @$each->subscription->no_of_days }}</td>
                                        <td>{{date('Y D, M d - H:i A',strtotime($each->started_at))}}</td> 
                                        <td>{{date('Y D, M d - H:i A',strtotime($each->ended_at))}}</td> 
                                        <td>{{ strtoupper($each->status) }}</td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                            {{ $subscription_histories->links() }}
                        </div>

                    </div>
                <!-- End of earning section -->
            </div>
        </div>
        <!-- Endd of earning content -->
    </div>                
</div>
@endsection 