@extends('admin.layout.base')

@section('title', 'Update User ')

@section('content')


<div class="content-area py-1">
    <div class="container-fluid">
    	<div class="box box-block bg-white">

    	    <a href="{{  url('admin/city', $country->id) }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> Back</a>

			<h5 style="margin-bottom: 2em;">Update City</h5>

            <form class="form-horizontal" action="{{ url('admin/city/update') }}" method="POST" enctype="multipart/form-data" role="form">
            	{{csrf_field()}}
            
				
				<div class="form-group row">
					<label for="name" class="col-xs-2 col-form-label">Country Name</label>
					<div class="col-xs-10">
						<input class="form-control" type="text" value="{{ $country->name }}" name="name" required id="name" placeholder="Name" readonly="true">
					</div>
				</div>

				<div class="form-group row">
					<label for="code" class="col-xs-2 col-form-label">Country Code</label>
					<div class="col-xs-10">
						<input class="form-control" type="text" value="{{ $country->code }}" name="code" required id="code" placeholder="Code" readonly="true">
					</div>
				</div>

				<div class="form-group row">
					<label for="code" class="col-xs-2 col-form-label">City</label>
					<div class="col-xs-10">
						<input type="text" name="city" placeholder="City" class="form-control" value="{{ $cities[0]->name }}" id="city">
					</div>
				</div>
				<input type='hidden' value="{{$cities[0]->id}}" name='CityId'>

				<div class="form-group row">
					<label for="zipcode" class="col-xs-2 col-form-label"></label>
					<div class="col-xs-10">
						<button type="submit" class="btn btn-primary">Update City</button>
						<a href="{{route('admin.country.index')}}" class="btn btn-default">Cancel</a>
					</div>
				</div>
			</form>
		</div>
    </div>
</div>






@endsection

@section('scripts')



	

	<script src="https://maps.googleapis.com/maps/api/js?key={{ Setting::get('map_key') }}&libraries=places&callback=initMap&region={{$country_code}}"
            async defer></script>

	<script type="text/javascript">
		function initMap() {
			var countrycode=document.getElementById('code').value;
		    var options = {
		        types: ['(cities)'],
		        componentRestrictions: {country: countrycode}
		    };
		    var input = document.getElementById('city');
		    var autocomplete = new google.maps.places.Autocomplete(input, options);
		}
		google.maps.event.addDomListener(window, 'load', initialize);
	</script>

@endsection
