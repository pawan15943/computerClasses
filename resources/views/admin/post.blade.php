@extends('layouts.master')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />    
           
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Posts</h1>
    <div class="card shadow mb-4 py-4">
        <div class="col-lg-10">
            <form id="submit"  enctype="multipart/form-data">
                @csrf
            
                <div class="row g-4">
                    <input type="hidden" name="id" value="" id="posts_id">
                   
                    <div class="col-lg-4 mt-2">
                        <label for="post_title">Post Title</label>                       
                        <input type="text" id="post_title" name="post_title" value="{{ old('post_title') }}" class="form-control @error('post_title') is-invalid @enderror" placeholder="Post Title"  >
                
                        @error('post_title')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="col-lg-4 mt-2">
                        <label for="post_alt_value">Post Alt Value</label>                       
                        <input type="text" id="post_alt_value" name="post_alt_value" value="{{ old('post_alt_value') }}" class="form-control @error('post_alt_value') is-invalid @enderror" placeholder="Post Alt Value"  >
                
                        @error('post_alt_value')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="col-lg-2  mt-2">
                        <label for="post_image">Post Image </label>                       
                        <input type="file" id="post_image" name="post_image" value="{{ old('post_image') }}" class="form-control @error('post_image') is-invalid @enderror" placeholder="Post Image"  >
                
                    </div>
                 
                    <div class="col-lg-2  mt-3">
                        <button type="submit"  class="btn btn-primary mt-4" >Submit</button>
                    </div>

                </div>
            
            </form>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Posts</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Post Id</th>
                            <th>Post Title</th>
                            <th>Post alt value </th>
                            <th>Post Image </th>
                            
                            <th>Active</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                         @foreach($posts as $key => $post)
                        <tr>
                            <td>{{$post->id}}</td>
                            <td>{{$post->post_title}}</td>
                            <td>{{$post->post_alt_value}}</td>
                           
                            <td><a href="{{$post->post_image}}">Download</a></td>
                            @if($post->is_active==1)
                            <td>Active</td>
                            @else
                            <td>Unactive</td>
                            @endif
                            <td>
                                <a href="javascript:void(0)" type="button" class="post_edit" data-id="{{$post->id}}">Edit</a>
                                <a href="javascript:void(0)" type="button" class="delete" data-id="{{$post->id}}">Delete</a>
                           
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
<script src="path/to/csrf-token-setup.js"></script>



<script type="text/javascript">
$(document).ready(function() {
   
    $(document.body).on('submit', '#submit', function(event){
        event.preventDefault();
        var formData = new FormData(); 
        var post_title = $("#post_title").val();
        var post_alt_value = $("#post_alt_value").val();
        var post_image = $("#post_image")[0].files[0];
        var post_id=$('#posts_id').val();
        formData.append('post_title', post_title);
        formData.append('id', post_id);
        formData.append('post_image', post_image);
        formData.append('post_alt_value', post_alt_value);
        formData.append('_token', '{{ csrf_token() }}');
        if(post_title=='' || post_title==undefined ){
            Swal.fire({
                title: 'Error!',
                text: 'Assets Name is required.', 
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }
        if(post_alt_value=='' || post_alt_value==undefined ){
            Swal.fire({
                title: 'Error!',
                text: 'Assets File is required.', 
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }
        if(post_image=='' || post_image==undefined ){
            Swal.fire({
                title: 'Error!',
                text: 'Assets File is required.', 
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }
       


            $.ajax({
                url: '{{ route('post.store') }}',
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
                        
                            location.reload(); 
                            
                        });
                    }else if (response.errors) {
                          
                          $(".is-invalid").removeClass("is-invalid");
                          $(".invalid-feedback").remove();

                          $.each(response.errors, function (key, value) {
                            console.log(key);
                              $("input[name='" +key+"']").addClass("is-invalid");
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

    $(document.body).on('click','.post_edit',function(){
        var post_id=$(this).data('id');

            
            $.ajax({
                    url: '{{ route('post.edit') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: 'GET',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": post_id,
                       
                    },

                    dataType: 'json',
                    success: function (response) {
                        console.log(response);
                        $('#post_title').val(response.post.post_title);
                        $('#post_alt_value').val(response.post.post_alt_value);
                        $('#post_image').val(response.post.post_image);
                        $('#posts_id').val(response.post.id);
                      
                       
                      
                    }
                });

    });

     $('.delete').click(function(e) {
        if(!confirm('Are you sure you want to delete this Course?')) {
            e.preventDefault();
        }
        var post_id=$(this).data('id');
        $.ajax({
            url: '{{ route('post.destroy') }}',
            type: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                "id": post_id,
                       
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