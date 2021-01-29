@extends('admin.layout.base')

@section('title', 'Add User ')

@section('content')

<div class="content-area py-1">
    <div class="container-fluid">
    	<div class="box box-block bg-white">
            <a href="{{ route('admin.user.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> @lang('admin.back')</a>

			<h5 style="margin-bottom: 2em;">@lang('admin.users.Add_User')</h5>

            <form class="form-horizontal" action="{{route('admin.user.store')}}" method="POST" enctype="multipart/form-data" role="form">
            	{{csrf_field()}}
				<div class="form-group row">
					<label for="first_name" class="col-xs-12 col-form-label">@lang('admin.first_name')</label>
					<div class="col-xs-10">
						<input class="form-control" type="text" value="{{ old('first_name') }}" name="first_name" required id="first_name" placeholder="First Name">
					</div>
				</div>

				<div class="form-group row">
					<label for="last_name" class="col-xs-12 col-form-label">@lang('admin.last_name')</label>
					<div class="col-xs-10">
						<input class="form-control" type="text" value="{{ old('last_name') }}" name="last_name" required id="last_name" placeholder="Last Name">
					</div>
				</div>

				<div class="form-group row">
					<label for="email" class="col-xs-12 col-form-label">@lang('admin.email')</label>
					<div class="col-xs-10">
						<input class="form-control" type="email" required name="email" value="{{old('email')}}" id="email" placeholder="Email">
					</div>
				</div>

				<div class="form-group row">
					<label for="password" class="col-xs-12 col-form-label">@lang('admin.password')</label>
					<div class="col-xs-10">
						<input class="form-control" type="password" name="password" id="password" placeholder="Password">
					</div>
				</div>

				<div class="form-group row">
					<label for="password_confirmation" class="col-xs-12 col-form-label">@lang('admin.account.password_confirmation')</label>
					<div class="col-xs-10">
						<input class="form-control" type="password" name="password_confirmation" id="password_confirmation" placeholder="Re-type Password">
					</div>
				</div>

				<div class="form-group row">
					<label for="picture" class="col-xs-12 col-form-label">@lang('admin.picture')</label>
					<div class="col-xs-10">
						<input type="file" accept="image/*" name="picture" class="dropify form-control-file" id="picture" aria-describedby="fileHelp">
					</div>
				</div>

				<div class="form-group row">
					<label for="mobile" class="col-xs-12 col-form-label">@lang('admin.mobile')</label>
					<div class="col-xs-10">
						<input class="form-control" type="number" value="{{ old('mobile') }}" name="mobile" required id="mobile" placeholder="Mobile">
					</div>
				</div>
				<div class="form-group row">
					<label for="mobile" class="col-xs-12 col-form-label">Country</label>
					<div class="col-xs-10">
	                    <select class="form-control country" name="country_id" required>
	                    <option value="">Select Country</option>
	                    @foreach(countries() as $country)
	                    <option value="{{$country->id}}">{{$country->name}}</option>
	                    @endforeach
	                    </select>

	                    @if ($errors->has('country_id'))
	                    <span class="help-block">
	                    <strong>{{ $errors->first('country_id') }}</strong>
	                    </span>
	                    @endif                        
                	</div>
                </div>

                <div class="form-group row">
					<label for="mobile" class="col-xs-12 col-form-label">City</label>
					<div class="col-xs-10">
	                    <select class="form-control city" name="city_id" required>
	                    <option value="">Select City</option>
	                    </select>
	                    @if ($errors->has('city'))
	                    <span class="help-block">
	                    <strong>{{ $errors->first('city') }}</strong>
	                    </span>
	                    @endif 
	                </div>
                </div>

				<div class="form-group row">
					<label for="zipcode" class="col-xs-12 col-form-label"></label>
					<div class="col-xs-10">
						<button type="submit" class="btn btn-primary">@lang('admin.users.Add_User')</button>
						<a href="{{route('admin.user.index')}}" class="btn btn-default">@lang('admin.cancel')</a>
					</div>
				</div>
			</form>
		</div>
    </div>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<script type="text/javascript">
	
	 $('.country').on('change', function() {
    
     $('.city').find('.append-value').remove();
      
     var id = $(this).find('option:selected').val();
     var root = $(this);
     if(id != ''){
         $.get('/citydropdown/'+id).done(function(response){
           
             $(response.city).each(function(index, value){
                 $('.city').append('<option value="'+value.id+'" class="append-value">'+value.name+'</option>');
             });
         });
     }
    });


</script>
@endsection