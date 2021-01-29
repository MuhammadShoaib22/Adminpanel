@extends('admin.layout.base')

@section('title', 'Update User ')

@section('content')

<div class="content-area py-1">
    <div class="container-fluid">
    	<div class="box box-block bg-white">
    	    <a href="{{ route('admin.country.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> Back</a>

			<h5 style="margin-bottom: 2em;">Update Country</h5>

            <form class="form-horizontal" action="{{route('admin.country.update', $country->id )}}" method="POST" enctype="multipart/form-data" role="form">
            	{{csrf_field()}}
            	<input type="hidden" name="_method" value="PATCH">
				<div class="form-group row">
					<label for="name" class="col-xs-2 col-form-label">Name</label>
					<div class="col-xs-10">
						<input class="form-control" type="text" value="{{ $country->name }}" name="name" required id="name" placeholder="Name">
					</div>
				</div>

				<div class="form-group row">
					<label for="code" class="col-xs-2 col-form-label">Code</label>
					<div class="col-xs-10">
						<input class="form-control" type="text" value="{{ $country->code }}" name="code" required id="code" placeholder="Code">
					</div>
				</div>

				<div class="form-group row">
					<label for="dial_code" class="col-xs-2 col-form-label">Dial Code</label>
					<div class="col-xs-10">
						<input class="form-control" type="text" value="{{ $country->dial_code }}" name="dial_code" required id="dial_code" placeholder="Dial Code">
					</div>
				</div>

				<div class="form-group row">
					<label for="currency_name" class="col-xs-2 col-form-label">Currency Name</label>
					<div class="col-xs-10">
						<input class="form-control" type="text" value="{{ $country->currency_name }}" name="currency_name" required id="currency_name" placeholder="Currency Name">
					</div>
				</div>

				<div class="form-group row">
					<label for="currency_symbol" class="col-xs-2 col-form-label">Currency Symbol</label>
					<div class="col-xs-10">
						<input class="form-control" type="text" value="{{ $country->currency_symbol }}" name="currency_symbol" required id="currency_symbol" placeholder="Currency Symbol">
					</div>
				</div>

				<div class="form-group row">
					<label for="currency_code" class="col-xs-2 col-form-label">Currency Code</label>
					<div class="col-xs-10">
						<input class="form-control" type="text" value="{{ $country->currency_code }}" name="currency_code" required id="currency_code" placeholder="Currency Code">
					</div>
				</div>

				<div class="form-group row">
					<label for="zipcode" class="col-xs-2 col-form-label"></label>
					<div class="col-xs-10">
						<button type="submit" class="btn btn-primary">Update Country</button>
						<a href="{{route('admin.country.index')}}" class="btn btn-default">Cancel</a>
					</div>
				</div>
			</form>
		</div>
    </div>
</div>

@endsection
