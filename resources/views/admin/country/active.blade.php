@extends('admin.layout.base')

@section('title', 'Service Types ')

@section('content')

    <div class="content-area py-1">
        <div class="container-fluid">
            
            <div class="box box-block bg-white">
            
                <h5 class="mb-1">Active Country</h5>
             
                <table class="table table-striped table-bordered dataTable" id="table-2">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Country Name</th>
                            <th>Code</th>
                            <th>Dial Code</th>
                            <th>currency Name</th>                            
                            <th>Currency Symbol</th>                       
                            <th>Currency Code</th>
                            <th>Cities</th>
                            <th>Time Zone</th>
                            <th>Status</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>
                    @foreach($wc as $index => $w)
                        <tr>
                            <td>{{$index + 1}}</td>
                            <td>{{$w->name}}</td>
                            <td>{{$w->code}}</td>
                            <td>{{$w->dial_code}}</td>
                            <td>{{$w->currency_name}}</td>                            
                            <td>{{$w->currency_symbol}}</td>
                            <td>{{$w->currency_code}}</td>
                            <td>                                
                                <a href="{{ url('admin/city', $w->id) }}" class="btn btn-success"><i class="fa fa-building"></i> Cities</a>
                            </td>
                 
                            <td>
                                <button class="btn btn-primary open_modal" id="time_zone" data-id="{{$w->code}}">Time Zone</button>
                            </td>
                            <td>
                                @if($w->status == 0)
                                <a href="{{ route('admin.country.status', $w->id) }}" class="btn btn-success">Activate</a>
                                @else
                                <a href="{{ route('admin.country.status', $w->id) }}" class="btn btn-danger">De-activate</a>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.country.edit', $w->id) }}" class="btn btn-info"><i class="fa fa-pencil"></i> Edit</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                             <th>ID</th>
                            <th>Country Name</th>
                            <th>Code</th>
                            <th>Dial Code</th>
                            <th>currency Name</th>                            
                            <th>Currency Symbol</th>                       
                            <th>Currency Code</th>
                            <th>Cities</th>
                            <th>Time Zone</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
        </div>
    </div>
    
    <div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog">
      
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h4 class="modal-title">Active TimeZones List</h4>
          </div>
          <div class="modal-body">

            <div id="table_active">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Time Zone </th>
                            <th>UTC offset</th>
                            <th>UTC DST offset</th>
                        </tr> 
                    </thead>
                    <tbody class="table-body">
                        <tr><td>1</td><td>Asia/Kabul</td><td>+04:30</td><td>+04:30</td></tr>
                    </tbody>
                </table>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
        
      </div>
    </div>
@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('click', '#time_zone', function(){
            var code = $(this).attr('data-id');
            $.get('/admin/timezone/'+code).done(function(response){
                $('.table-body').empty();
                $(response).each(function(index, value){
                    var id = index+1;
                    $('.table-body').append('<tr><td>'+id+'</td><td>'+value.time_zone+'</td><td>'+value.utc_offset+'</td><td>'+value.utc_dst_offset+'</td></tr>');
                });
            });
            $('#myModal').modal('show');
        });
    });
</script>
@endsection