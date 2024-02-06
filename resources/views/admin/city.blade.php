@extends('layouts.master')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />               
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Add City Name</h1>
    <div class="card shadow mb-4 py-4">
        <div class="col-lg-12">
            <form id="submit" >
                @csrf
                @if(session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif

                <div class="row g-4">
                    <input type="hidden" name="id" value="" id="city_id">
                   <div class="col-lg-3">
                        <select id="countryid" name="country_id" class="form-control @error('country') is-invalid @enderror">
                            @error('country')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                            <option value="">Select Country</option>
                            @foreach ($countrys as $key => $country)
                            <option value="{{$country}}">{{$key}}</option> 
                            @endforeach
                        
                        </select>
                   </div>
                    <div class="col-lg-3">
                        <select id="stateid" name="state_id" class="form-control @error('state') is-invalid @enderror" placeholder="Select State">
                            @error('state')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                            <option value="">Select State</option>
                          
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <input type="text" id="city" name="city_name" value="{{ old('city') }}" class="form-control @error('city') is-invalid @enderror" placeholder="City Name"  >
                
                        @error('city')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                     </div>

                   
                    <div class="col-lg-3">
                        <button type="submit"  class="btn btn-primary btn-block">Add City </button>
                    </div>

                </div>
            
            </form>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">City List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>City Id</th>
                            <th>City Name</th>
                            <th>State </th>
                            <th>Country </th>
                            <th>Active</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @foreach($citys as $key => $city)
                        <tr>
                            <td>{{$city->city_id}}</td>
                            <td>{{$city->city_name}}</td>
                            <td>{{$city->state_name}}</td>
                            <td>{{$city->country_name}}</td>
                            
                            @if($city->is_active==1)
                            <td>Active</td>
                            @else
                            <td>Unactive</td>
                            @endif
                            <td>
                                <a href="javascript:void(0)" type="button" class="city_edit" data-id="{{$city->city_id}}">Edit</a>
                                <a href="javascript:void(0)" type="button" class="delete" data-id="{{$city->city_id}}">Delete</a>
                           
                            </td>
                        </tr>
                        @endforeach
                    
                    </tbody>
                </table>
            </div>
        </div>
    </div>


</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>




<script type="text/javascript">
$(document).ready(function() {
   
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
    
    $(document.body).on('submit', '#submit', function(event){
        event.preventDefault();
            var country_id = $("#countryid").val();
            var state_id = $("#stateid").val();   
            var city_name = $('#city').val();
            var city_id=$('#city_id').val();
          
            if(country_id=='' || country_id==undefined ){
                Swal.fire({
                    title: 'Error!',
                    text: 'Country is required.', 
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }
            if(state_id=='' || state_id==undefined ){
                Swal.fire({
                    title: 'Error!',
                    text: 'State is required.', 
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }
            if(city_name=='' || city_name==undefined ){
                Swal.fire({
                    title: 'Error!',
                    text: 'City is required.', 
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }


                $.ajax({
                    url: '{{ route('city.store') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        country_id: country_id,
                        state_id: state_id,
                        city_name: city_name,
                        id:city_id,
                    },

                    dataType: 'json',
                    success: function (response) {
                        
                        if (response.success) {
                            Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success'
                            }).then(function () {
                                location.reload();
                            });
                        } else if (response.errors) {
                          
                            $(".is-invalid").removeClass("is-invalid");
                            $(".invalid-feedback").remove();

                            $.each(response.errors, function (key, value) {
                            
                                if(key=='city_name'){
                                    $("#city" ).addClass("is-invalid");
                                    $("#city").after('<span class="invalid-feedback" role="alert">' + value + '</span>');
                                }
                                if(key=='country_id'){
                                    $("#countryid" ).addClass("is-invalid");
                                    $("#countryid").after('<span class="invalid-feedback" role="alert">' + value + '</span>');
                                }
                                if(key=='state_id'){
                                    $("#stateid" ).addClass("is-invalid");
                                    $("#stateid").after('<span class="invalid-feedback" role="alert">' + value + '</span>');
                                }
                             
                            });
                        } else {
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
     $(document.body).on('click','.city_edit',function(){
        var city_id=$(this).data('id');
            console.log(city_id);
            $.ajax({
                    url: '{{ route('city.edit') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: 'GET',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": city_id,
                       
                    },

                    dataType: 'json',
                    success: function (response) {
                        
                        $('#city_id').val(response.city.id);
                        $('#countryid').val(response.city.country_id);
                        $('#city').val(response.city.city_name);
                        $("#stateid").append('<option value="'+response.city.state_id+'"selected>'+response.state+'</option>');
                    }
                });

    });

     $('.delete').click(function(e) {
        if(!confirm('Are you sure you want to delete this City?')) {
            e.preventDefault();
        }
        var city_id=$(this).data('id');
        $.ajax({
            url: '{{ route('city.destroy') }}',
            type: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                "id": city_id,
                       
                },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        title: 'Success!',
                        text: response.message,
                        icon: 'success'
                    }).then(function() {
                       
                        location.reload(); 
                        
                    });
                } else {
                    // Handle other cases if needed
                }
            },
            error: function(error) {
                // Handle errors if the AJAX request fails
            }
        });

     });
    });
    
</script>
               
 @endsection