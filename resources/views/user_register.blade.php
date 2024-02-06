@extends('layouts.master')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />               
<div class="container-fluid">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                {{-- <div class="col-lg-5 d-none d-lg-block bg-register-image"></div> --}}
                <div class="col-lg-12">
                    <div class="p-5">
                        <div class="">
                            <h1 class="h4 text-gray-900 mb-4">Add User Account </h1>
                        </div>
                        <form class="user" id="submit">
                            @csrf
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="text" class="form-control " id="name" name="name"
                                        placeholder="Name">
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control digit-only" id="phone" name="phone"
                                        placeholder="Mobile No.">
                                </div>
                               
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control " id="email" name="email"
                                    placeholder="Email Address">
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="password" class="form-control "
                                        id="password" placeholder="Password" name="password">
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control " id="address" name="address"
                                        placeholder="Address">
                                </div>
                           
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <select id="role" name="role" class="form-control  @error('role') is-invalid @enderror" placeholder="Role Select">
                                        <option value=""> Select Role</option>
                                        @foreach($roles as $key => $role)
                                        <option value="{{$role->name}}"> {{$role->name}}</option>
                                            
                                        @endforeach
                                    </select>  
                                </div>
                            
                            </div>
                            <button type="submit"  class="btn btn-primary  mt-4" >Add Account</button>
                         
                        </form>
                      
                    </div>
                </div>
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
         
                var name = $('#name').val();
                var phone = $('#phone').val();
                var email = $('#email').val();
                var address = $('#address').val();
                var role = $('#role').val();
                var password = $('#password').val();
       
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
                        text: 'Phone is required.', 
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }
                if(email=='' || email==undefined ){
                    Swal.fire({
                        title: 'Error!',
                        text: 'Email is required.', 
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
                if(role=='' || role==undefined ){
                    Swal.fire({
                        title: 'Error!',
                        text: 'Role is required.', 
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }
                if(password=='' || password==undefined ){
                    Swal.fire({
                        title: 'Error!',
                        text: 'Password is required.', 
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }
               
    
                    $.ajax({
                        url: '{{ route('user.store') }}',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        },
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            name: name,
                            email: email,
                            phone: phone,
                            address: address,
                            role: role,
                            password:password
                           
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
                          
                                $(".is-invalid").removeClass("is-invalid");
                                $(".invalid-feedback").remove();

                                $.each(response.errors, function (key, value) {
                                
                                    $("input[name='" +key+"']").addClass("is-invalid");
                                    $("select[name='" +key+"']").addClass("is-invalid");
                                    $("input[name='"+key+"']").after('<span class="invalid-feedback" role="alert">' + value + '</span>');
                                
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