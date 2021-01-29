@extends('admin.layout.base')

@section('title', 'Update User ')

@section('content')

<!-- edit page -->
<div class="content-area py-1">
    <div class="container-fluid">
    	<div class="box box-block bg-white">
    	    <a href="{{ route('admin.user.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> Back</a>

			<h5 style="margin-bottom: 2em;">Update User</h5>

            <form class="form-horizontal" action="{{route('admin.user.update', $user->id )}}" method="POST" enctype="multipart/form-data" role="form">
            	{{csrf_field()}}
            	<input type="hidden" name="_method" value="PATCH">
				<div class="form-group row">
					<label for="first_name" class="col-xs-2 col-form-label">First Name</label>
					<div class="col-xs-10">
						<input class="form-control" type="text" value="{{ $user->first_name }}" name="first_name" required id="first_name" placeholder="First Name">
					</div>
				</div>

				<div class="form-group row">
					<label for="last_name" class="col-xs-2 col-form-label">Last Name</label>
					<div class="col-xs-10">
						<input class="form-control" type="text" value="{{ $user->last_name }}" name="last_name" required id="last_name" placeholder="Last Name">
					</div>
				</div>


				<div class="form-group row">
					
					<label for="picture" class="col-xs-2 col-form-label">Picture</label>
					<div class="col-xs-10">
					@if(isset($user->picture))
                    	<img style="height: 90px; margin-bottom: 15px; border-radius:2em;" src="{{img($user->picture)}}">
                    @endif
						<input type="file" accept="image/*" name="picture" class="dropify form-control-file" id="picture" aria-describedby="fileHelp">
					</div>
				</div>

				<div class="form-group row">
					<label for="mobile" class="col-xs-2 col-form-label">Mobile</label>
					<div class="col-xs-10">
						<input class="form-control" type="text" value="{{ $user->mobile }}" name="mobile" required id="mobile" placeholder="Mobile">
					</div>
				</div> 

				@if($user->country_id)
				<div class="form-group row">
					<label for="mobile" class="col-xs-2 col-form-label">Country</label>
					<div class="col-xs-10">
						<input class="form-control" type="text" value="{{ @App\Country::find(@$user->country_id)->name }}" disabled="">
					</div>
				</div>

				<div class="form-group row">
					<label for="mobile" class="col-xs-2 col-form-label">City</label>
					<div class="col-xs-10">
						<input class="form-control" type="text" value="{{ @App\Cities::find(@$user->city_id)->name }}" disabled="">
					</div>
				</div>
                @else
				<div class="form-group row">
					<label for="mobile" class="col-xs-2 col-form-label">Country</label>
					<div class="col-xs-10">
						 <select class="form-control" name="country_id" required>
	                        <option value="">Select Country</option>
	                        @foreach(countries() as $country)
	                        <option value="{{$country->id}}">{{$country->name}}</option>
	                        @endforeach
                        </select>
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
				@endif

				<div class="form-group row">
					<label for="zipcode" class="col-xs-2 col-form-label"></label>
					<div class="col-xs-10">
						<button type="submit" class="btn btn-primary">Update User</button>
						<a href="{{route('admin.user.index')}}" class="btn btn-default">Cancel</a>
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
