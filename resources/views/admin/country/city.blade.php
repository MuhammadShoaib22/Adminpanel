@extends('admin.layout.base')

@section('title', 'Users ')

@section('content')
 

    <div class="content-area py-1">


        <div class="container-fluid">
        
            <div class="box box-block bg-white">

    <a href="{{  url('admin/active/country') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> Back</a>

    <a href="{{ url('admin/city/add', $country->id) }}" style="margin-left: 1em;" class="btn btn-primary pull-right"><i class="fa fa-building"></i> Add City</a>

    <br>
                <h5 class="mb-1">All Cities</h5>

                <table class="table table-striped table-bordered dataTable" id="cus-city-table">
                    <thead>
                        <tr>
                            <th>ID</th> 
                            <th>Country</th>                           
                            <th>City</th>
                            <th>Status</th>
                            <th>Action</th>
                            
                          
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($cities as $index => $city)
                        <tr>
                            <td>{{$index + 1}}</td>
                            <td>{{$countryname}}</td>
                            <td>{{$city->name}}</td>
                            <td>
                                @if($city->status == 0)
                                <a href="{{ url('admin/city/status', $city->id) }}" class="btn btn-success">Activate</a>
                                @else
                                <a href="{{ url('admin/city/status', $city->id) }}" class="btn btn-danger">De-activate</a>
                                @endif
                            </td>
                             <td>
                                <a href="{{ url('admin/city/edit', $city->id) }}" class="btn btn-info"><i class="fa fa-pencil"></i> Edit</a>
                            </td>
                           
                            
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                             <th>Country</th> 
                            <th>Name</th>
                            <th>Status</th>
                            <th>Action</th>
                           
                        </tr>
                    </tfoot>
                </table>
            </div>
            
        </div>
    </div>

@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function(){
       $('#cus-city-table').DataTable( {
        "pagingType": "full_numbers"
    } ); 
    });
</script>
@endsection