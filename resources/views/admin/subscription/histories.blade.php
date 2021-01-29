@extends('admin.layout.base')

@section('title', 'Subscription Histories ')

@section('content')

    <div class="content-area py-1">
        <div class="container-fluid">
            
            <div class="box box-block bg-white">
                @if(Setting::get('demo_mode') == 1)
                    <div class="col-md-12" style="height:50px;color:red;">
                        ** Demo Mode : No Permission to Edit and Delete.
                    </div>
                @endif
                <h5 class="mb-1">@lang('admin.subscription_history.subscrption_histories')</h5> 
                <table class="table table-striped table-bordered dataTable" id="table-2">
                    <thead>
                        <tr> 
                            <th>@lang('admin.id')</th>
                            <th>@lang('admin.subscription_history.provider_name')</th>
                            <th>@lang('admin.subscription_history.name')</th>
                            <th>@lang('admin.subscription_history.amount')</th>
                            <th>@lang('admin.subscription_history.no_of_days')</th>
                            <th>@lang('admin.subscription_history.started_at')</th>
                            <th>@lang('admin.subscription_history.expired_at')</th>
                            <th>@lang('admin.subscription_history.Status')</th> 
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($histories as $index => $historie)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $historie->provider ? $historie->provider->first_name : '' }}</td>
                            <td>{{ $historie->subscription->name }}</td>
                            <td>{{ $historie->subscription->amount }}</td>
                            <td>{{ $historie->subscription->no_of_days }}</td>
                            <td>{{date('Y D, M d - H:i A',strtotime($historie->started_at))}}</td> 
                            <td>{{date('Y D, M d - H:i A',strtotime($historie->ended_at))}}</td> 
                            <td>{{ strtoupper($historie->status) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>@lang('admin.id')</th>
                            <th>@lang('admin.subscription_history.provider_name')</th>
                            <th>@lang('admin.subscription_history.name')</th>
                            <th>@lang('admin.subscription_history.amount')</th>
                            <th>@lang('admin.subscription_history.no_of_days')</th>
                            <th>@lang('admin.subscription_history.started_at')</th>
                            <th>@lang('admin.subscription_history.expired_at')</th>
                            <th>@lang('admin.subscription_history.Status')</th> 
                        </tr>
                    </tfoot>
                </table>
            </div>
            
        </div>
    </div>
@endsection