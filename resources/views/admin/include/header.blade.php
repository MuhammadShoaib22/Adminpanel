
<!-- Header -->
<div class="site-header">
	<nav class="navbar navbar-light">
		<div class="navbar-left">
			<a class="navbar-brand" href="{{url('admin/dashboard')}}">
				<div class="logo" style="background: url({{ Setting::get('site_logo', asset('logo-black.png')) }}) no-repeat;"></div>
			</a>
			<div class="toggle-button dark sidebar-toggle-first float-xs-left hidden-md-up">
				<span class="hamburger"></span>
			</div>
			<div class="toggle-button-second dark float-xs-right hidden-md-up">
				<i class="ti-arrow-left"></i>
			</div>
			<div class="toggle-button dark float-xs-right hidden-md-up" data-toggle="collapse" data-target="#collapse-1">
				<span class="more"></span>
			</div>
		</div>
		<div class="navbar-right navbar-toggleable-sm collapse" id="collapse-1">
			<div class="toggle-button light sidebar-toggle-second float-xs-left hidden-sm-down">
				<span class="hamburger"></span>
			</div>

			<ul class="nav navbar-nav">
				<li class="nav-item hidden-sm-down">
					<a class="nav-link toggle-fullscreen" href="#">
						<i class="ti-fullscreen"></i>
					</a>
				</li>
			</ul>
			<div class="col-md-3" style="margin-top: 13px;">
				<select class="form-control" id="country_code">
					<option value="">Select Country</option>
					@foreach(countries() as $country)
					<option value="{{$country->code}}" @if(Session::get('country_code','IN')== $country->code) selected @endif>{{$country->name}}</option>
					@endforeach
				</select>
			</div>
			<ul class="nav navbar-nav float-md-right">
				<li class="nav-item dropdown hidden-sm-down">
					<a href="#" data-toggle="dropdown" aria-expanded="false">
						<span class="avatar box-32">
							<img src="{{img(Auth::guard('admin')->user()->picture)}}" alt="">
						</span>
					</a>
					<div class="dropdown-menu dropdown-menu-right animated fadeInUp">
						<a class="dropdown-item" href="{{route('admin.profile')}}">
							<i class="ti-user mr-0-5"></i> @lang('admin.include.profile')
						</a>
						<a class="dropdown-item" href="{{route('admin.password')}}">
							<i class="ti-settings mr-0-5"></i> @lang('admin.account.change_password')
						</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="{{route('admin.help')}}"><i class="ti-help mr-0-5"></i> @lang('admin.help')</a>
						<a class="dropdown-item" href="{{ url('/admin/logout') }}"
                            onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();"><i class="ti-power-off mr-0-5"></i> @lang('admin.include.sign_out')</a>
					</div>
				</li>
			</ul>

		</div>
	</nav>
</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<script type="text/javascript">
	
	 $('#country_code').on('change', function() { 
      
     var country_code = $(this).find('option:selected').val(); 
     if(country_code != ''){
         $.get('/countrycodedropdown/'+country_code).done(function(response){
           	if(response.message == 'success'){
           		var current_url = window.location.origin+window.location.pathname; 
	          	window.location.href = current_url+'?country_code='+country_code;
		  	}
         });
     }
    }); 
</script>