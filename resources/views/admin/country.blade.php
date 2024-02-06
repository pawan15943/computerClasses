@extends('layouts.master')
@section('content')
                
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Add Country Name</h1>
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
                    <input type="hidden" name="id" value="" id="country_id">

                    <div class="col-lg-9">
                        <input type="text" id="country" name="country_name" value="{{ old('country') }}" class="form-control @error('country_name') is-invalid @enderror" placeholder="Country Name"  >
                
                        @error('country_name')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                     </div>
                    <div class="col-lg-3">
                        <button type="submit" class="btn btn-primary btn-block" >Add Country</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Country List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Country Id</th>
                            <th>Name</th>
                            <th>Active</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @foreach($countrys as $key => $country)
                        <tr>
                            <td>{{$country->id}}</td>
                            <td>{{$country->country_name}}</td>
                            @if($country->is_active==1)
                            <td>Active</td>
                            @else
                            <td>Unactive</td>
                            @endif
                            <td>
                                <a href="javascript:void(0)" type="button" class="country_edit" data-id="{{$country->id}}">Edit</a>
                                <a href="javascript:void(0)" type="button" class="delete" data-id="{{$country->id}}">Delete</a>
                           
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
        $(document.body).on('submit', '#submit', function(event){
        event.preventDefault();
     
            var country = $('#country').val();
            var country_id=$('#country_id').val();
         
            if(country=='' || country==undefined ){
                Swal.fire({
                    title: 'Error!',
                    text: 'Country is required.', 
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }


                $.ajax({
                    url: '{{ route('country.store') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id: country_id,
                        country_name:country
                    },

                    dataType: 'json',
                    success: function (response) {
                        
                        if (response.success) {
                            Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success'
                            }).then(function() {
                            
                                location.reload(); 
                                
                            });
                        }else if (response.errors) {
                          
                            // Clear existing error messages
                            $(".is-invalid").removeClass("is-invalid");
                            $(".invalid-feedback").remove();

                            // Update form with new error messages
                            $.each(response.errors, function (key, value) {
                                if(key=='country_name'){
                                    $("#country" ).addClass("is-invalid");
                                    $("#country").after('<span class="invalid-feedback" role="alert">' + value + '</span>');
                                }
                              
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
     $(document.body).on('click','.country_edit',function(){
        var country_id=$(this).data('id');
           
            $.ajax({
                    url: '{{ route('country.edit') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: 'GET',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": country_id,
                       
                    },

                    dataType: 'json',
                    success: function (response) {
                        
                        $('#country_id').val(response.country.id);
                        $('#country').val(response.country.country_name);
                    
                    }
                });

    });
    $('.delete').click(function(e) {
        if(!confirm('Are you sure you want to delete this Country?')) {
            e.preventDefault();
        }
        var country_id=$(this).data('id');
        $.ajax({
            url: '{{ route('country.destroy') }}',
            type: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                "id": country_id,
                       
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