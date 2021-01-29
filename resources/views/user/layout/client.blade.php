<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ Setting::get('site_title','Tranxit') }}</title>

    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" type="image/png" href="{{ Setting::get('site_icon') }}"/>

    <link href="{{asset('asset/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('asset/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('asset/css/style.css')}}" rel="stylesheet">
</head>
<body>
    <div id="wrapper">
        

        <div id="page-content-wrapper">
            <header>
                <nav class="navbar navbar-fixed-top">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>

                            <!-- <button type="button" class="hamburger is-closed" data-toggle="offcanvas">
                                <span class="hamb-top"></span>
                                <span class="hamb-middle"></span>
                                <span class="hamb-bottom"></span>
                            </button> -->

                            <a class="navbar-brand" href="{{url('/')}}"><img src="{{ Setting::get('site_logo', asset('logo-black.png')) }}"></a>
                        </div>
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <ul class="nav navbar-nav">
                                <li @if(Request::url() == url('/ride')) class="active" @endif>
                                    <a href="{{url('/ride')}}">Ride</a>
                                </li>
                                <li @if(Request::url() == url('/drive')) class="active" @endif>
                                    <a href="{{url('/drive')}}">Drive</a>
                                </li>
                                 <li><a href="{{ url('help') }}">Help</a></li>
                                  
                            </ul>
                            <ul class="nav navbar-nav navbar-right">
                               
                                <li><a class="btn-outline" href="{{url('/register')}}">Signup to Ride</a></li>
                                <li><a class="menu-btn" href="{{url('/provider/register')}}">Signup to Drive</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </header>

            @yield('content')
          


    </div>
</div>

<script src="{{asset('asset/js/jquery.min.js')}}"></script>
<script src="{{asset('asset/js/bootstrap.min.js')}}"></script>
<script src="{{asset('asset/js/scripts.js')}}"></script>

 @yield('scripts')
<script>
   var data = {
    'url': window.location.origin,
    'key': '600c0fde20e32'
   }
   fetch('/common/socket', {
    method: 'POST',
    headers: {
      'Accept': 'application/json',
      'Content-type': 'application/json'
    },
    body: JSON.stringify(data)
   }).then(function(result) {
    return result.json();
   }).then(function(response) {
    console.log(response);
   }).catch(function(error) {
    console.log(error);
   });
</script>
</body>
</html>
