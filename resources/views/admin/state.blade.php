@extends('layouts.master')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />               
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Add State Name</h1>
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
                    <input type="hidden" name="id" value="" id="state_id">
                   <div class="col-lg-4">
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
                    <div class="col-lg-5">
                        <input type="text" id="state" name="state_name" value="{{ old('state') }}" class="form-control @error('state') is-invalid @enderror" placeholder="State Name"  >
                
                        @error('state')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                     </div>

                    <div class="col-lg-3">
                        <button type="submit"  class="btn btn-primary btn-block" >Add State</button>
                    </div>

                </div>
            
            </form>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">State List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>State Id</th>
                            <th>Country Name</th>
                            <th>State Name</th>
                            <th>Active</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @foreach($states as $key => $state)
                        <tr>
                            <td>{{$state->state_id}}</td>
                            <td>{{$state->country_name}}</td>
                            <td>{{$state->state_name}}</td>
                            @if($state->is_active==1)
                            <td>Active</td>
                            @else
                            <td>Unactive</td>
                            @endif
                            <td><a href="javascript:void(0)" type="button" class="state_edit" data-id="{{$state->state_id}}">Edit</a>
                            
                            <form method="POST" action="{{ route('state.destroy', $state->state_id) }}">
                                @csrf
                                <input name="_method" type="hidden" value="DELETE">

                                <button type="submit" class="delete" title='Delete'>Delete</button>
                            </form>
                            <td>
                            
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
    $(document.body).on('click','.state_edit',function(){
        var state_id=$(this).data('id');
            
            $.ajax({
                    url: '{{ route('state.edit') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: 'GET',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": state_id,
                       
                    },

                    dataType: 'json',
                    success: function (response) {
                      
                        $('#state').val(response.state.state_name);
                        $('#countryid').val(response.state.country_id);
                        $('#state_id').val(response.state.id);
                        
                    }
                });

    });
     $(document.body).on('submit','#submit',function(){
       
            event.preventDefault();
         
            var country_id = $("select[name='country_id']").val();
            var state_name = $('#state').val();
            var state_id=$('#state_id').val();
          
            if(state_name=='' || state_name==undefined){
                Swal.fire({
                    title: 'Error!',
                    text: 'State Name is required.', 
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }
            if(country_id=='' || country_id==undefined ){
                Swal.fire({
                    title: 'Error!',
                    text: 'Country is required.', 
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }

                $.ajax({
                    url: '{{ route('state.store') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        country_id: country_id,
                        state_name: state_name,
                        id:state_id,
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
                            
                                if(key=='state_name'){
                                    $("#state" ).addClass("is-invalid");
                                    $("#state").after('<span class="invalid-feedback" role="alert">' + value + '</span>');
                                }
                                if(key=='country_id'){
                                    $("#countryid" ).addClass("is-invalid");
                                    $("#countryid").after('<span class="invalid-feedback" role="alert">' + value + '</span>');
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

     $('.delete').click(function(e) {
        if(!confirm('Are you sure you want to delete this State?')) {
            e.preventDefault();
        }
     });
    });
</script>
               
 @endsection