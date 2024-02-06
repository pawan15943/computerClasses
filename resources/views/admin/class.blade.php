@extends('layouts.master')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />               
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Class</h1>
    <div class="card shadow mb-4 py-4">
        <div class="col-lg-10">
            <form id="submit" >
                @csrf
            
                <div class="row g-4">
                    <input type="hidden" name="id" value="" id="class_id">
                   
                    <div class="col-lg-4 mt-2">
                        <label for="class_name"> Class Name</label>                       
                        <input type="text" id="class_name" name="class_name" value="{{ old('class_name') }}" class="form-control @error('class_name') is-invalid @enderror" placeholder="Class Name"  >
                
                        @error('class_name')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
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
            <h6 class="m-0 font-weight-bold text-primary">Class List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Class Id</th>
                            <th>Class Name</th>
                            <th>Active</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @foreach($grades as $key => $value)
                        <tr>
                            <td>{{$value->id}}</td>
                            <td>{{$value->class_name}}</td>
                           
                            @if($value->is_active==1)
                            <td>Active</td>
                            @else
                            <td>Unactive</td>
                            @endif
                            <td>
                                <a href="javascript:void(0)" type="button" class="class_edit" data-id="{{$value->id}}">Edit</a>
                                <a href="javascript:void(0)" type="button" class="delete" data-id="{{$value->id}}">Delete</a>
                           
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
    
        var class_name = $('#class_name').val();
      
        var class_id=$('#class_id').val();
        
     
        if(class_name=='' || class_name==undefined ){
            Swal.fire({
                title: 'Error!',
                text: 'Class Name is required.', 
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }
      
            $.ajax({
                url: '{{ route('class.store') }}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    class_name: class_name, 
                    id: class_id,
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
                          
                            $("#" + key).addClass("is-invalid");
                            $("#" + key).after('<span class="invalid-feedback" role="alert">' + value + '</span>');
                            
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

    $(document.body).on('click','.class_edit',function(){
        var class_id=$(this).data('id');
            
            $.ajax({
                    url: '{{ route('class.edit') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: 'GET',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": class_id,
                       
                    },

                    dataType: 'json',
                    success: function (response) {
                        
                        $('#class_name').val(response.grade.class_name);
                        $('#class_id').val(response.grade.id);
                       
                      
                    }
                });

    });

     $('.delete').click(function(e) {
        if(!confirm('Are you sure you want to delete this Course?')) {
            e.preventDefault();
        }
        var class_id=$(this).data('id');
        $.ajax({
            url: '{{ route('class.destroy') }}',
            type: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                "id": class_id,
                       
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