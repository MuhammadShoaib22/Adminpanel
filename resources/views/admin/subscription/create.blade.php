@extends('admin.layout.base')

@section('title', 'Add Subscription ')

@section('content')

<div class="content-area py-1">
    <div class="container-fluid">
    	<div class="box box-block bg-white">
            <a href="{{ route('admin.subscription.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> @lang('admin.back')</a>

			<h5 style="margin-bottom: 2em;">@lang('admin.include.add_subscription')</h5>

            <form class="form-horizontal" action="{{route('admin.subscription.store')}}" method="POST" enctype="multipart/form-data" role="form">
            	{{csrf_field()}}
				<div class="form-group row">
					<label for="name" class="col-xs-2 col-form-label">@lang('admin.subscription.name')</label>
					<div class="col-xs-10">
						<input class="form-control" autocomplete="off"  type="text" value="{{ old('name') }}" name="name" required id="name" placeholder="Name">
					</div>
				</div>
				<div class="form-group row">
					<label for="description" class="col-xs-2 col-form-label">@lang('admin.subscription.description')</label>
					<div class="col-xs-10">
						<input class="form-control" type="text" value="{{ old('description') }}" name="description" required id="description" placeholder="Description">
					</div>
				</div>
				<div class="form-group row">
					<label for="commission" class="col-xs-2 col-form-label">Provider Commission(%)</label>
					<div class="col-xs-10">
						<input class="form-control" type="text" value="{{ old('provider_commission') }}" name="provider_commission" required id="commission" placeholder="Commision">
					</div>
				</div>
				<div class="form-group row">
					<label for="image" class="col-xs-2 col-form-label">@lang('admin.subscription.image')</label>
					<div class="col-xs-10">
						<input type="file" accept="image/*" name="image" class="dropify form-control-file" id="image" aria-describedby="fileHelp">
					</div>
				</div>

				<div class="form-group row">
					<label for="amount" class="col-xs-2 col-form-label">@lang('admin.subscription.amount')</label>
					<div class="col-xs-10">
						<input class="form-control" type="number" value="{{ old('amount') }}" name="amount" required id="amount" placeholder="Amount">
					</div>
				</div>
				<div class="form-group row">
					<label for="no_of_days" class="col-xs-2 col-form-label">@lang('admin.subscription.no_of_days')</label>
					<div class="col-xs-10">
						<input class="form-control" type="number" value="{{ old('no_of_days') }}" name="no_of_days" required id="no_of_days" placeholder="Days">
					</div>
				</div>

				<div class="form-group row">
					<label for="rides_per_period" class="col-xs-2 col-form-label">@lang('admin.subscription.include_rides_per_period')</label>
					<div class="col-xs-10">
						<input class="form-control" type="number" value="{{ old('rides_per_period') }}" name="rides_per_period" required id="rides_per_period" placeholder="@lang('admin.subscription.include_rides_per_period')">
					</div>
				</div>

				<!-- <div class="form-group row">
					<label for="order_fee_booking" class="col-xs-2 col-form-label">@lang('admin.subscription.order_fee_booking')</label>
					<div class="col-xs-10">
						<input class="form-control" type="number" value="{{ old('order_fee_booking') }}" name="order_fee_booking" required id="order_fee_booking" placeholder="@lang('admin.subscription.order_fee_booking')">
					</div>
				</div>
				
				<div class="form-group row">
					<label for="order_fee_dispatch" class="col-xs-2 col-form-label">@lang('admin.subscription.order_fee_dispatch')</label>
					<div class="col-xs-10">
						<input class="form-control" type="number" value="{{ old('order_fee_dispatch') }}" name="order_fee_dispatch" required id="order_fee_dispatch" placeholder="@lang('admin.subscription.order_fee_dispatch')">
					</div>
				</div>
				
				<div class="form-group row">
					<label for="transaction_fee_cash" class="col-xs-2 col-form-label">@lang('admin.subscription.transaction_fee_cash')</label>
					<div class="col-xs-10">
						<input class="form-control" type="number" value="{{ old('transaction_fee_cash') }}" name="transaction_fee_cash" required id="transaction_fee_cash" placeholder="@lang('admin.subscription.transaction_fee_cash')">
					</div>
				</div>
				
				<div class="form-group row">
					<label for="transaction_fee_terminal" class="col-xs-2 col-form-label">@lang('admin.subscription.transaction_fee_terminal')</label>
					<div class="col-xs-10">
						<input class="form-control" type="number" value="{{ old('transaction_fee_terminal') }}" name="transaction_fee_terminal" required id="transaction_fee_terminal" placeholder="@lang('admin.subscription.transaction_fee_terminal')">
					</div>
				</div>
				
				<div class="form-group row">
					<label for="transaction_fee_third_party" class="col-xs-2 col-form-label">@lang('admin.subscription.transaction_fee_third_party')</label>
					<div class="col-xs-10">
						<input class="form-control" type="number" value="{{ old('transaction_fee_third_party') }}" name="transaction_fee_third_party" required id="transaction_fee_third_party" placeholder="@lang('admin.subscription.transaction_fee_third_party')">
					</div>
				</div>
				
				<div class="form-group row">
					<label for="transaction_fee_bank_card" class="col-xs-2 col-form-label">@lang('admin.subscription.transaction_fee_bank_card')</label>
					<div class="col-xs-10">
						<input class="form-control" type="number" value="{{ old('transaction_fee_bank_card') }}" name="transaction_fee_bank_card" required id="transaction_fee_bank_card" placeholder="@lang('admin.subscription.transaction_fee_bank_card')">
					</div>
				</div>
 -->

				<div class="form-group row">
					<label for="zipcode" class="col-xs-2 col-form-label"></label>
					<div class="col-xs-10">
						<button type="submit" class="btn btn-primary">@lang('admin.include.add_subscription')</button>
						<a href="{{route('admin.subscription.index')}}" class="btn btn-default">@lang('admin.cancel')</a>
					</div>
				</div>
			</form>
		</div>
    </div>
</div>

@endsection
