@extends('admin.layout.base')

@section('title', 'Users ')

@section('content')
 
<style type="text/css">
    .dataTables_wrapper
    {
        overflow: scroll;
        height: 400px;
    }
</style>
    <div class="content-area py-1">


        <div class="container-fluid">
        <form class="form-horizontal" action="{{url('admin/service/city/update')}}" method="POST" enctype="multipart/form-data" role="form">
                {{ csrf_field() }}
            <div class="box box-block bg-white">

    <a href="{{ URL::previous() }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> Back</a>

   

    <br>
                <h4 class="mb-1">All Activated Cities in {{$country->name}}</h5>
                <h5 class="mb-1">Service type : <strong>{{$service->name}}</strong></h5>
                
                <table class="table table-striped table-bordered dataTable" id='table-2' style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>                                                      
                            <th>City</th>

                            
                            <th>@lang('admin.service.hourly_Price') ({{ currency() }})</th>
                            <th>@lang('admin.service.Base_Price') ({{ currency() }})</th>
                            <th>@lang('admin.service.Base_Distance') ({{ distance() }})</th>
                            <th>@lang('admin.service.unit_time')</th>                
                            <th>@lang('admin.service.unit')({{ distance() }})</th>   
                            <th>@lang('admin.service.Seat_Capacity') </th>                             
                            
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($wc as $index => $w)
                                <tr>
                                <td>{{$index + 1}}</td> 

                                      
                                         @foreach($w->world as $index => $wd)                     
                            
                             <td width="3px">{{$wd->name}}</td>

                      @endforeach

                                 <td width="10px">  <input class="hourly_price form-control" type="number" value="{{ $w->hour }}" name="hour[{{ $w->city_id}}]" id="hourly_price" placeholder="Set Hour Price (Only for DISTANCEHOUR)" min="0"> </td>

                                        <td width="10px">  <input class="fixed form-control" type="number" value="{{ $w->fixed }}" name="fixed[{{ $w->city_id}}]" required id="fixed" placeholder="Base Price" min="0"> </td>

                                        <td width="10%">   <input class="distance form-control" type="number" value="{{ $w->distance }}" name="distance[{{ $w->city_id}}]" id="distance" placeholder="Base Distance" min="0"> </td> 

                                        <td width="10%"> <input class="minute form-control" type="number" value="{{ $w->minute }}" name="minute[{{ $w->city_id}}]" id="minute" placeholder="Unit Time Pricing" min="0"> </td>

                                        <td width="10%">    <input class="price form-control" type="number" value="{{ $w->price }}" name="price[{{ $w->city_id}}]" id="price" placeholder="Unit Distance Price" min="0">  </td>

                                        <td width="10%"> <input class="capacity form-control" type="number" value="{{ $w->capacity }}" name="capacity[{{ $w->city_id}}]" required id="capacity" placeholder="Seat Capacity" min="1"></td>



                                </tr>
                    @endforeach

                    @foreach($list_city as $index => $city)
                        <tr>
                            <td>{{$index + 1}}</td>                            
                            <td>{{$city->name}}</td>

                        
             
                        <td >  <input class="hourly_price form-control" type="number" value="{{ old('fixed') }}" name="hour[{{ $city->id}}]"  id="hourly_price" placeholder="Set Hour Price( Only For DISTANCEHOUR )" min="0"> </td>

                        <td >  <input class="form-control" type="number" value="{{ old('fixed') }}" name="new_fixed[{{ $city->id}}]"  id="new_fixed" placeholder="Base Price" min="0"> </td>

                        <td >  <input class="distance form-control" type="number" value="{{ old('distance') }}" name="distance[{{ $city->id}}]"  id="distance" placeholder="Base Distance" min="0"> </td>                       
                        <td > <input class="minute form-control" type="number" value="{{ old('minute') }}" name="minute[{{ $city->id}}]"  id="minute" placeholder="Unit Time Pricing" min="0">  </td>

                        <td >    <input class="price form-control" type="number" value="{{ old('price') }}" name="price[{{ $city->id}}]"  id="price" placeholder="Unit Distance Price" min="0">  </td>

                        <td ><input class="form-control" type="number" value="{{ old('capacity') }}" name="capacity[{{ $city->id}}]"  id="capacity" placeholder="Capacity" min="1"></td>                          
                                             
                            
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>ID</th>                             
                            <th>City</th> 

                            
                            <th>@lang('admin.service.hourly_Price') ({{ currency() }})</th>
                            <th>@lang('admin.service.Base_Price') ({{ currency() }})</th>
                            <th>@lang('admin.service.Base_Distance') ({{ distance() }})</th>
                            <th>@lang('admin.service.unit_time')</th>                
                            <th>@lang('admin.service.unit')({{ distance() }})</th>   
                            <th>@lang('admin.service.Seat_Capacity') </th>                           
                            
                           
                        </tr>
                    </tfoot>
                </table>
            <br>
                 <div class="col-xs-12 col-sm-6 offset-md-4 col-md-3">
                                <button type="submit" class="btn btn-primary btn-block">Update</button>
                </div>
            <br>
            </div>
            <input type='hidden' name='serviceID' value='{{$service->id}}'>
            <input type='hidden' name='calculator' value='{{$service->calculator}}'>
            <input type='hidden' name='country_id' value='{{$country->id}}'>
            
            </form>
        </div>
    </div>

@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function(){
       $('#cus-city-table').DataTable( {
        "pagingType": "full_numbers"
    } ); 

       priceInputs('{{$service->calculator}}');
    });


function priceInputs(cal){



    if(cal=='MIN'){
            $(".hourly_price,.distance,.price").attr('value','');
            $(".minute").prop('disabled', false); 
           
            $(".hourly_price,.distance,.price").prop('disabled', true);
           
            $("#changecal").text('BP + (TM*PM)'); 
        }
        else if(cal=='HOUR'){
            $(".minute,.distance,.price").attr('value',''); 
            $(".hourly_price").prop('disabled', false);
            
            $(".minute,.distance,.price").prop('disabled', true);
            
            $("#changecal").text('BP + (TH*PH)');
        }
        else if(cal=='DISTANCE'){
            $(".minute,.hourly_price").attr('value',''); 
            $(".price,.distance").prop('disabled', false);
       
            $(".minute,.hourly_price").prop('disabled', true);
            
            $("#changecal").text('BP + (T{{Setting::get("distance")}}-BD*P{{Setting::get("distance")}})');
        }
        else if(cal=='DISTANCEMIN'){
            $(".hourly_price").attr('value',''); 
            $(".price,.distance,.minute").prop('disabled', false);
            
            $(".hourly_price").prop('disabled', true);
           
            $("#changecal").text('BP + (T{{Setting::get("distance")}}-BD*P{{Setting::get("distance")}}) + (TM*PM)');
        }
        else if(cal=='DISTANCEHOUR'){
            $(".minute").attr('value',''); 
            $(".price,.distance,.hourly_price").prop('disabled', false);
           
            $(".minute").prop('disabled', true);
            
            $("#changecal").text('BP + ((T{{Setting::get("distance")}}-BD)*P{{Setting::get("distance")}}) + (TH*PH)');
        }
        else{
            $(".minute,.hourly_price").attr('value',''); 
            $(".price,.distance").prop('disabled', false);
            
            $(".minute,.hourly_price").prop('disabled', true);
            
            $("#changecal").text('BP + (T{{Setting::get("distance")}}-BD*P{{Setting::get("distance")}})');
        }
}












</script>
@endsection