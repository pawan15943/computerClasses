@extends('layouts.master')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />               
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Role</h1>
    <div class="card shadow mb-4 py-4">
        <div class="col-lg-10">
            <form id="submit" >
                @csrf
            
               
                @if(session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif

                <div class="row g-4">
                    <input type="hidden" name="id" value="" id="role_id">
                   
                   
                    <div class="col-lg-6">
                        <label for="role"> Role Name </label>                       
                        <input type="text" id="role" name="name" value="{{ old('role') }}" class="form-control @error('role') is-invalid @enderror" placeholder="role Name"  >
                
                        @error('role')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                     </div>

                   
                    
                    <div class="col-lg-12">
                        <label for="permission"> Permissions </label><br>  
                        @foreach($permission as $value)
                        <span class="p-4"> {{ $value->name }}</span>
                        <input type="checkbox"  name="permission[]" class="form-check-input permission-checkbox" value="{{ $value->id }}" id="permission_{{ $value->id }}">
                        
                        @endforeach
                       </div>

                       <div class="col-lg-2">
                        <button type="submit"  class="btn btn-primary mt-4" >Submit</button>
                    </div>

                </div>
            
            </form>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Role Id</th>
                            <th>Role Name</th>
                          
                            <th>Action</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @foreach($roles as $key => $role)
                        <tr>
                            <td>{{$role->id}}</td>
                            <td>{{$role->name}}</td>
                            
                            
                         
                            <td>
                                <a href="javascript:void(0)" type="button" class="role_edit" data-id="{{$role->id}}">Edit</a>
                                <a href="javascript:void(0)" type="button" class="delete" data-id="{{$role->id}}">Delete</a>
                           
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
     
            var role_name = $('#role').val();
            var role_id=$('#role_id').val();
            var permission_values = [];

            // Get selected permission values
            $('.permission-checkbox:checked').each(function(){
                permission_values.push($(this).val());
            });

            // Check if at least one permission is selected
            if(permission_values.length === 0){
                Swal.fire({
                    title: 'Error!',
                    text: 'At least one permission is required.', 
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }
           
            if(role_name=='' || role_name==undefined ){
                Swal.fire({
                    title: 'Error!',
                    text: 'Role is required.', 
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }
           


                $.ajax({
                    url: '{{ route('role.store') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        name: role_name,
                        id: role_id,
                        permission: permission_values
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
     $(document.body).on('click','.role_edit',function(){
        var role_id=$(this).data('id');
            console.log(role_id);
            $.ajax({
                    url: '{{ route('role.edit') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: 'GET',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": role_id,
                       
                    },

                    dataType: 'json',
                    success: function (response) {
                        console.log(response);
                        $('#role_id').val(response.role.id);
                     
                        $('#role').val(response.role.name);
                        
                        // Uncheck all checkboxes first
                        $('.permission-checkbox').prop('checked', false);

                        // Check checkboxes based on rolePermissions array
                        $.each(response.rolePermissions, function(index, value) {
                            $('#permission_' + value).prop('checked', true);
                        });
                       
                    }
                });

    });

     $('.delete').click(function(e) {
        if(!confirm('Are you sure you want to delete this City?')) {
            e.preventDefault();
        }
        var role_id=$(this).data('id');
        $.ajax({
            url: '{{ route('role.destroy') }}',
            type: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                "id": role_id,
                       
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