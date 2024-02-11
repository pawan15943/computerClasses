@extends('layouts.master')
@section('content')
<style>
    .avatar-upload {
    position: relative;
    max-width: 205px;
    margin: 50px auto;
    .avatar-edit {
        position: absolute;
        right: 12px;
        z-index: 1;
        top: 10px;
        input {
            display: none;
            + label {
                display: inline-block;
                width: 34px;
                height: 34px;
                margin-bottom: 0;
                border-radius: 100%;
                background: #FFFFFF;
                border: 1px solid transparent;
                box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
                cursor: pointer;
                font-weight: normal;
                transition: all .2s ease-in-out;
                &:hover {
                    background: #f1f1f1;
                    border-color: #d6d6d6;
                }
                &:after {
                    content: "\f040";
                    font-family: 'FontAwesome';
                    color: #757575;
                    position: absolute;
                    top: 10px;
                    left: 0;
                    right: 0;
                    text-align: center;
                    margin: auto;
                }
            }
        }
    }
    .avatar-preview {
        width: 192px;
        height: 192px;
        position: relative;
        border-radius: 100%;
        border: 6px solid #F8F8F8;
        box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
         {
            width: 100%;
            height: 100%;
            border-radius: 100%;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }
    }
}
</style>
<meta name="csrf-token" content="{{ csrf_token() }}" />               
<div class="container-fluid">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="text-center ">
            <h4 class="mt-4">Update Profile</h4>
            </div>
            <form id="submit">    
                @csrf
                <input type="hidden" value="{{Auth::user()->id}}" id="user_id" name="user_id">
             
                <div class="avatar-upload">
                    <div class="">
                        <input type='file' id="imageUpload" name="user_photo" @error('image') is-invalid @enderror accept=".png, .jpg, .jpeg" />
                       
                    </div>
                    @error('image')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    @if($user_profile)
                    
                            @php
                            // dd(Auth::user()->user_photo);
                            if(Auth::user()->user_photo !=null){
                                $photo = Auth::user()->user_photo;
                            }elseif(Auth::user()->user_photo == null && $user_profile->gender == 'M') {
                                $photo = "img/male.png";
                            } elseif (Auth::user()->user_photo == null && $user_profile->gender == 'F') {
                                $photo = "img/female.png";
                            } else {
                                $photo = "img/male.png";
                            }
                            @endphp 
                              <div class="avatar-preview">
                                <img src="{{$photo}}" width="200" height="100" class="image_preview">
                            </div> 
                    @else
                    <div class="avatar-preview">
                        <img src="" width="200" height="100" class="image_preview">
                    </div> 
                    @endif 
                   
                </div>
            <div class="row">

                <div class="col-md-6">
                    <div class="p-5">
                        <input type="hidden" id="role_name" value="{{ Auth::user()->roles->pluck('name')[0] }}" name="role_name">
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="text" class="form-control form-control-user" id="name" value="{{Auth::user()->name}}"
                                        placeholder="Name" name="name">
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control form-control-user @error('phone') is-invalid @enderror" id="phone" value="{{Auth::user()->phone}}"
                                        placeholder="Mobile No." name="phone">
                                        @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                </div>
                               
                            </div>
                           
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="email" class="form-control form-control-user" id="email" value="{{Auth::user()->email}}"
                                    placeholder="Email Address" name="email" readonly>
                                </div>
                               
                                <div class="col-sm-6">
                                    @if($user_profile)
                                    <input type="date" class="form-control form-control-user  @error('dob') is-invalid @enderror" id="dob"
                                    placeholder="Date of Birth" name="dob" value="@if($user_profile->dob){{$user_profile->dob}}@endif">
                                    @else
                                    <input type="date" class="form-control form-control-user  @error('dob') is-invalid @enderror" id="dob"
                                    placeholder="Date of Birth" name="dob" value="">
                                    @endif
                                  

                                        @error('dob')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                </div>
                           
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                   
                                        <input type="text" class="form-control form-control-user" id="address" value="{{Auth::user()->address}}"
                                        placeholder="Address" name="address">
                                </div>
                                <div class="col-sm-6">
                                <select id="countryid" name="country_id" class="form-control @error('country') is-invalid @enderror">
                                    @error('country')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                    <option value="">Select Country</option>
                                    @if($user_profile)
                                    @foreach ($countrys as $key => $country)
                                    <option value="{{$country}}" @if($country == $user_profile->country_id) {{ "selected" }} @endif>{{$key}}</option> 
                                    @endforeach
                                    @else
                                    @foreach ($countrys as $key => $country)
                                    <option value="{{$country}}" >{{$key}}</option> 
                                    @endforeach
                                    @endif
                                
                                </select>
                                </div>
                               
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <select id="stateid" name="state_id" class="form-control @error('state') is-invalid @enderror" placeholder="Select State">
                                        @error('state')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                        @if($user_profile)
                                            @foreach ($selectedState as $key => $value)
                                            <option value="{{$value}}" @if($value == $user_profile->state_id) {{ "selected" }} @endif>{{$key}}</option> 
                                            @endforeach
                                            
                                        @else
                                        <option value="">Select State</option> 
                                        @endif
                                        
                                      
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <select id="cityid" name="city_id" class="form-control @error('city') is-invalid @enderror" placeholder="Select City">
                                        @error('city')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                        @if($user_profile)
                                        @foreach ($selectedcity as $key => $value)
                                        <option value="{{$value}}" @if($value == $user_profile->city_id) {{ "selected" }} @endif>{{$key}}</option> 
                                        @endforeach
                                            
                                        @else
                                        <option value="">Select City</option>
                                        @endif
                                       
                                      
                                    </select>
                                </div>
                           
                            </div>
                         
                    </div>
                   
                </div>
                <div class="col-md-6">
                        <div class="p-5">
                            <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                @if($user_profile)
                                <input type="radio" class="gender" name="gender" value="M" @if($user_profile->gender == 'M') checked @endif>
                                  <label for="gender">Male</label>
                                 <input type="radio"  class="gender" name="gender" value="F" @if($user_profile->gender == 'F') checked @endif>
                                  <label for="gender">Female</label>
                                @else
                                <input type="radio" class="gender" name="gender" value="M" >
                                  <label for="gender">Male</label>
                                 <input type="radio"  class="gender" name="gender" value="F" >
                                  <label for="gender">Female</label>
                                @endif
                            </div>
                            </div>
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="text" class="form-control form-control-user" id="father_name" value=""
                                    placeholder="Father Name" name="father_name">
                            </div>
                           
                         </div>
                          
                </div>
           
            </div>
            <div class="text-center ">
            <button type="submit"  class="btn btn-primary btn-user mb-4" >Submit</button>
            </div>
            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
 
    $(document).ready(function() {
  
            $(document).on('change','#imageUpload', function() {
                $('.error_success_msg_container').html('');
                if (this.files && this.files[0]) {
                    let img = document.querySelector('.image_preview');
                    img.onload = () =>{
                        URL.revokeObjectURL(img.src);
                    }
                    img.src = URL.createObjectURL(this.files[0]);
                    document.querySelector(".image_preview").files = this.files;
                }
            });

            $('#countryid').on('change', function(event){
                event.preventDefault();
                var country_id = $(this).val();
            
                if(country_id){
                    $.ajax({
                            url: '{{ route('stateGetConutryWise') }}',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            },
                            type: 'GET',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "country_id": country_id,
                            
                            },

                            dataType: 'json',
                            success: function (html) {
                                
                                if(html){
                                    $("#stateid").empty();
                                    $("#stateid").append('<option value="">Select State</option>');
                                    $.each(html,function(key,value){
                                    
                                        $("#stateid").append('<option value="'+key+'">'+value+'</option>');
                                    });
                                }else{
                                    
                                    $("#stateid").append('<option value="">Select State</option>');
                                }
                                
                                    
                            }
                        });
                }else{
                    $("#stateid").empty();
                    $("#stateid").append('<option value="">Select State</option>');
                }
            });
            
            $('#stateid').on('change', function(event){
                event.preventDefault();
                var state_id = $(this).val();
                if(state_id){
                    $.ajax({
                            url: '{{ route('cityGetStateWise') }}',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            },
                            type: 'GET',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "state_id": state_id,
                            
                            },

                            dataType: 'json',
                            success: function (html) {
                                
                                if(html){
                                    $("#cityid").empty();
                                    $("#cityid").append('<option value="">Select City</option>');
                                    $.each(html,function(key,value){
                                    
                                        $("#cityid").append('<option value="'+key+'">'+value+'</option>');
                                    });
                                }else{
                                    
                                    $("#cityid").append('<option value="">Select City</option>');
                                }
                                
                                    
                            }
                        });
                }else{
                    $("#cityid").empty();
                    $("#cityid").append('<option value="">Select City</option>');
                }
            });
            $(document.body).on('submit', '#submit', function(event){
                event.preventDefault();
                var formData = new FormData(this); 
                var name = $("#name").val();
                var phone = $("#phone").val();
                var dob = $("#dob").val();
                var address = $("#address").val();
                var countryid = $("#countryid").val();
                var stateid = $("#stateid").val();
                var cityid = $("#cityid").val();
                var courseId = $("#courseId").val();
                var fee_amount = $("#fee_amount").val();
                var user_photo = $("#imageUpload")[0].files[0];
                var gender= $("input[name='gender']:checked").val();
                var is_paid= $("input[name='is_paid']:checked").val();
                var is_certificate= $("input[name='is_certificate']:checked").val();
                var user_id=$('#user_id').val();
                var role_name = $("#role_name").val();
              
            
                formData.append('_token', '{{ csrf_token() }}');

                if(name=='' || name==undefined ){
                    Swal.fire({
                        title: 'Error!',
                        text: 'Name is required.', 
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }
                if(phone=='' || phone==undefined ){
                    Swal.fire({
                        title: 'Error!',
                        text: 'Phone No. is required.', 
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }
                if(dob=='' || dob==undefined ){
                    Swal.fire({
                        title: 'Error!',
                        text: 'DOB is required.', 
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }
                if(address=='' || address==undefined ){
                    Swal.fire({
                        title: 'Error!',
                        text: 'Address is required.', 
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }
                if(countryid=='' || countryid==undefined ){
                    Swal.fire({
                        title: 'Error!',
                        text: 'Country is required.', 
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }
                if(stateid=='' || stateid==undefined ){
                    Swal.fire({
                        title: 'Error!',
                        text: 'State is required.', 
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }
                if(cityid=='' || cityid==undefined ){
                    Swal.fire({
                        title: 'Error!',
                        text: 'City is required.', 
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }
                if(gender=='' || gender==undefined ){
                    Swal.fire({
                        title: 'Error!',
                        text: 'Gender is required.', 
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }
                if(user_photo=='' || user_photo==undefined ){
                    Swal.fire({
                        title: 'Error!',
                        text: 'Photo is required.', 
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }
                

                    $.ajax({
                        url: '{{ route('profile.store') }}',
                        type: 'POST',
                        data:formData,
                        
                        processData: false,
                        contentType: false,

                        dataType: 'json',
                        success: function (response) {
                            
                            if (response.success) {
                                Swal.fire({
                                    title: 'Success!',
                                    text: response.message,
                                    icon: 'success'
                                }).then(function() {
                                    if(response.student==1){
                                        window.location.href = '{{ route("studentfees") }}';
                                    }else{
                                        location.reload();
                                    }
                                 
                                });
                            }else if (response.errors) {
                          
                            $(".is-invalid").removeClass("is-invalid");
                            $(".invalid-feedback").remove();

                            $.each(response.errors, function (key, value) {
                                
                                $('[name='+ key+']').addClass("is-invalid");
                                $('[name='+ key+']').after('<span class="invalid-feedback" role="alert">' + value + '</span>');
                                
                            });
                            }else{
                                Swal.fire({
                                    title: 'Error!',
                                    text: response.message, 
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                            
                        }
                    });
            });
        
        });
</script>

 @endsection
 