@extends('admin.layout.base')

@section('title', 'Subscription ')

@section('content')

    <div class="content-area py-1">
        <div class="container-fluid">
            
            <div class="box box-block bg-white">
                @if(Setting::get('demo_mode') == 1)
                    <div class="col-md-12" style="height:50px;color:red;">
                        ** Demo Mode : No Permission to Edit and Delete.
                    </div>
                @endif
                <h5 class="mb-1">@lang('admin.include.subscription')</h5>
                <a href="{{ route('admin.subscription.create') }}" style="margin-left: 1em;" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> @lang('admin.include.add_subscription')</a>

                <table class="table table-striped table-bordered dataTable" id="table-2">
                    <thead>
                        <tr>
                            <th>@lang('admin.id')</th>
                            <th>@lang('admin.subscription.name') </th>
                            <th>@lang('admin.subscription.description') </th> 
                            <th>@lang('admin.subscription.image') </th> 
                            <th>@lang('admin.subscription.amount') </th> 
                            <th>@lang('admin.subscription.no_of_days') </th> 
                            <th>@lang('admin.action')</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($subscriptions as $index => $subscription)
                        <tr>
                            <td>{{$index + 1}}</td>
                            <td>{{$subscription->name}}</td> 
                            <td>{{$subscription->description}}</td> 
                            <td>@if($subscription->image) <img src="{{url('/storage',$subscription->image)}}" width="50%"> @endif</td>
                            <td>{{$subscription->amount}}</td> 
                            <td>{{$subscription->no_of_days}}</td>  
                            <td>
                                <form action="{{ route('admin.subscription.destroy', $subscription->id) }}" method="POST">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="_method" value="DELETE">
                                    @if( Setting::get('demo_mode') == 0)
                                    <a href="{{ route('admin.subscription.edit', $subscription->id) }}" class="btn btn-info"><i class="fa fa-pencil"></i> Edit</a>
                                    <button class="btn btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i> Delete</button>
                                    @endif
                                </form>
                            </td> 
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>@lang('admin.id')</th>
                            <th>@lang('admin.subscription.name') </th>
                            <th>@lang('admin.subscription.description') </th> 
                            <th>@lang('admin.subscription.image') </th> 
                            <th>@lang('admin.subscription.amount') </th> 
                            <th>@lang('admin.subscription.no_of_days') </th> 
                            <th>@lang('admin.action')</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
        </div>
    </div>
@endsection