@extends('user.layout.base')

@section('title', 'Profile ')

@section('content')

<div class="col-md-9">
    <div class="dash-content">
        <div class="row no-margin">
            <div class="col-md-12">
                <h4 class="page-title">@lang('user.profile.edit_information')</h4>
            </div>
        </div>
            @include('common.notify')
        <div class="row no-margin edit-pro">
            <form action="{{url('profile')}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
                <div class="col-md-12">
                    <label>@lang('user.profile.profile_picture')</label>
                    <div class="profile-img-blk">
                        <div class="img_outer">
                            <img class="profile_preview" id="profile_image_preview" src="{{img(Auth::user()->picture)}}" alt="your image"/>
                        </div>
                        <div class="fileUpload up-btn profile-up-btn">                   
                            <input type="file" id="profile_img_upload_btn" name="picture" class="upload" accept="image/x-png, image/jpeg"/>
                        </div>                             
                    </div> 
                </div>
                <div class="form-group col-md-6">
                    <label>@lang('user.profile.first_name')</label>
                    <input type="text" class="form-control" name="first_name" required placeholder="@lang('user.profile.first_name')" value="{{Auth::user()->first_name}}" data-validation="alphanumeric" data-validation-allowing=" -" data-validation-error-msg="First Name can only contain alphanumeric characters and . - spaces">
                </div>
                <div class="form-group col-md-6">
                    <label>@lang('user.profile.last_name')</label>
                    <input type="text" class="form-control" name="last_name" required placeholder="@lang('user.profile.last_name')" value="{{Auth::user()->last_name}}" data-validation-allowing=" -" data-validation-error-msg="Last Name can only contain alphanumeric characters and . - spaces">
                </div>

                <div class="form-group col-md-6">
                    <label>@lang('user.profile.email')</label>
                    <input type="email" class="form-control" placeholder="@lang('user.profile.email')" readonly value="{{Auth::user()->email}}">
                </div>

                <div class="form-group col-md-6">
                    <label>@lang('user.profile.mobile')</label>
                    <input type="text" class="form-control" name="mobile" required placeholder="@lang('user.profile.mobile')" value="{{Auth::user()->mobile}}" data-validation="custom length" data-validation-length="10-15" data-validation-regexp="^([0-9\+]+)$"data-validation-error-msg="Incorrect phone number">
                </div>

                     <div class="form-group col-md-6">
                    <label>Country</label>
                     <input type="text" class="form-control" placeholder="Country" readonly value="{{Auth::user()->country->name}}">
                                <!-- <select class="form-control country" name="country" >
                                <option value="">Select Country</option>
                                @foreach($countries as $country)
                                <option value="{{$country->id}}" @if(Auth::user()->country->id==$country->id) selected @endif>{{$country->name}}</option>
                                @endforeach
                                </select>

                                @if ($errors->has('country'))
                                <span class="help-block">
                                <strong>{{ $errors->first('country') }}</strong>
                                </span>
                                @endif     -->                    
                </div>
                <br>

               <div class="form-group col-md-6">
                    <label>City</label>
                     <input type="text" class="form-control" placeholder="City" readonly value="{{Auth::user()->city->name}}">

                                <!-- <select class="form-control city" name="city" required id='city'>
                                @foreach($country_city as $city)
                                <option value="{{$city->id}}"  @if(Auth::user()->city->id==$city->id) selected @endif>{{$city->name}}</option>
                                @endforeach
                                </select> -->

                </div>
                 

                <div class="form-group col-md-6">
                    <label>@lang('user.profile.language')</label>
                    @php($language=get_all_language())
                    <select class="form-control" name="language" id="language">
                        @foreach($language as $lkey=>$lang)
                            <option value="{{$lkey}}" @if(Auth::user()->language==$lkey) selected @endif>{{$lang}}</option>
                        @endforeach
                    </select>
                </div>
              
                <div class="col-md-12 pull-right">
                    <button type="submit" class="form-sub-btn big">@lang('user.profile.save')</button>
                </div>
            </form>
        </div>

    </div>
</div>

@endsection

@section('scripts')
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
<script type="text/javascript">

     $('.country').on('change', function() {
    
     $('.city').find('.append-value').remove();
      
     var id = $(this).find('option:selected').val();
     var root = $(this);
     if(id != ''){
         $.get('/citydropdown/'+id).done(function(response){
           $('.city').html('');
             $(response.city).each(function(index, value){
                
                 $('.city').append('<option value="'+value.id+'" class="append-value">'+value.name+'</option>');
             });
         });
     }
    });
   

 

    $.validate();       
</script>
@endsection