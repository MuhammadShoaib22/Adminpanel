@extends('admin.layout.base')

@section('title', 'Update Service Type ')

@section('content')

<div class="content-area py-1">
    <div class="container-fluid">
        <div class="box box-block bg-white">
            <a href="{{ route('admin.service.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> @lang('admin.back')</a>

            <h5 style="margin-bottom: 2em;">@lang('admin.service.Update_Service_Type')</h5>

            <form class="form-horizontal" action="{{route('admin.service.update', $service->id )}}" method="POST" enctype="multipart/form-data" role="form">
                {{csrf_field()}}
                <input type="hidden" name="_method" value="PATCH">
                <div class="form-group row">
                    <label for="name" class="col-xs-2 col-form-label">@lang('admin.service.Service_Name')</label>
                    <div class="col-xs-10">
                        <input class="form-control" type="text" value="{{ $service->name }}" name="name" required id="name" placeholder="Service Name">
                    </div>
                </div>

               <!--  <div class="form-group row">
                    <label for="provider_name" class="col-xs-2 col-form-label">@lang('admin.service.Provider_Name')</label>
                    <div class="col-xs-10">
                        <input class="form-control" type="text" value="{{ $service->provider_name }}" name="provider_name" required id="provider_name" placeholder="Provider Name">
                    </div>
                </div> -->

                <div class="form-group row">
                    
                    <label for="image" class="col-xs-2 col-form-label">@lang('admin.picture')</label>
                    <div class="col-xs-10">
                        @if(isset($service->image))
                        <img style="height: 90px; margin-bottom: 15px; border-radius:2em;" src="{{ $service->image }}">
                        @endif
                        <input type="file" accept="image/*" name="image" class="dropify form-control-file" id="image" aria-describedby="fileHelp">
                    </div>
                </div>

                 <div class="form-group row">
                    <label for="calculator" class="col-xs-2 col-form-label">@lang('admin.service.Pricing_Logic')</label>
                    <div class="col-xs-5">
                        <select class="form-control" id="calculator" name="calculator">
                            <option value="MIN" @if($service->calculator =='MIN') selected @endif>@lang('servicetypes.MIN')</option>
                            <option value="HOUR" @if($service->calculator =='HOUR') selected @endif>@lang('servicetypes.HOUR')</option>
                            <option value="DISTANCE" @if($service->calculator =='DISTANCE') selected @endif>@lang('servicetypes.DISTANCE')</option>
                            <option value="DISTANCEMIN" @if($service->calculator =='DISTANCEMIN') selected @endif>@lang('servicetypes.DISTANCEMIN')</option>
                            <option value="DISTANCEHOUR" @if($service->calculator =='DISTANCEHOUR') selected @endif>@lang('servicetypes.DISTANCEHOUR')</option>
                        </select>
                    </div>
                    <div class="col-xs-5">
                        <span class="showcal"><i><b>Price Calculation: <span id="changecal"></span></b></i></span>
                    </div>    
                </div>

                 <div class="form-group row">
                    <label for="description" class="col-xs-12 col-form-label">@lang('admin.service.Description')</label>
                    <div class="col-xs-12">
                        <textarea class="form-control" type="number"  name="description" required id="description" placeholder="Description" rows="4">{{ $service->description }}</textarea>
                    </div>
                </div>

                <table class="table table-striped table-bordered dataTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Country</th>
                        <th>Cities Price</th>
                             
                       
                    </tr>
                </thead>
                <tbody>
                     
                @foreach($list_country as $index => $ls)
                    <tr>
                        <td>{{$index + 1}}</td>
                        <td>{{$ls->name}}</td>
                        <td width="3px"><a href="{{ url('admin/service/city', [$ls->code,$service_id]) }}" class="btn btn-success">Cities Price</a>
                        </td>
                    </tr>
                @endforeach

                </tbody>
                
            </table>
            <br>
            <div class="form-group row">
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <a href="{{route('admin.service.index')}}" class="btn btn-danger btn-block">@lang('admin.cancel')</a>
                    </div>
                    <div class="col-xs-12 col-sm-6 offset-md-6 col-md-3">
                        <button type="submit" class="btn btn-primary btn-block">@lang('admin.service.Update_Service_Type')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    var cal='DISTANCE';
    priceInputs('{{$service->calculator}}');
    $("#calculator").on('change', function(){       
        cal=$(this).val();
        priceInputs(cal);
    });

    function priceInputs(cal){
        if(cal=='MIN'){
            $(".hourly_price,.distance,.price").attr('value','');
            $(".minute").prop('disabled', false); 
            $(".minute").prop('required', true); 
            $(".hourly_price,.distance,.price").prop('disabled', true);
            $(".hourly_price,.distance,.price").prop('required', false);
            $("#changecal").text('BP + (TM*PM)'); 
        }
        else if(cal=='HOUR'){
            $(".minute,.distance,.price").attr('value',''); 
            $(".hourly_price").prop('disabled', false);
            $(".hourly_price").prop('required', true);
            $(".minute,.distance,.price").prop('disabled', true);
            $(".minute,.distance,.price").prop('required', false);
            $("#changecal").text('BP + (TH*PH)');
        }
        else if(cal=='DISTANCE'){
            $(".minute,.hourly_price").attr('value',''); 
            $(".price,.distance").prop('disabled', false);
            $(".price,.distance").prop('required', true);
            $(".minute,.hourly_price").prop('disabled', true);
            $(".minute,.hourly_price").prop('required', false);
            $("#changecal").text('BP + (T{{Setting::get("distance")}}-BD*P{{Setting::get("distance")}})');
        }
        else if(cal=='DISTANCEMIN'){
            $(".hourly_price").attr('value',''); 
            $(".price,.distance,.minute").prop('disabled', false);
            $(".price,.distance,.minute").prop('required', true);
            $(".hourly_price").prop('disabled', true);
            $(".hourly_price").prop('required', false);
            $("#changecal").text('BP + (T{{Setting::get("distance")}}-BD*P{{Setting::get("distance")}}) + (TM*PM)');
        }
        else if(cal=='DISTANCEHOUR'){
            $(".minute").attr('value',''); 
            $(".price,.distance,.hourly_price").prop('disabled', false);
            $(".price,.distance,.hourly_price").prop('required', true);
            $(".minute").prop('disabled', true);
            $(".minute").prop('required', false);
            $("#changecal").text('BP + ((T{{Setting::get("distance")}}-BD)*P{{Setting::get("distance")}}) + (TH*PH)');
        }
        else{
            $(".minute,.hourly_price").attr('value',''); 
            $(".price,.distance").prop('disabled', false);
            $(".price,.distance").prop('required', true);
            $(".minute,.hourly_price").prop('disabled', true);
            $(".minute,.hourly_price").prop('required', false);
            $("#changecal").text('BP + (T{{Setting::get("distance")}}-BD*P{{Setting::get("distance")}})');
        }
    }

</script>
@endsection