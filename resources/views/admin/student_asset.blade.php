@extends('layouts.master')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />    
           
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Student Assets</h1>
    <div class="card shadow mb-4 py-4">
        <div class="col-lg-10">
            <form id="submit"  enctype="multipart/form-data">
                @csrf
            
                <div class="row g-4">
                    <input type="hidden" name="id" value="" id="assets_id">
                   
                    <div class="col-lg-4 mt-2">
                        <label for="asset_name"> Asset Name</label>                       
                        <input type="text" id="asset_name" name="asset_name" value="{{ old('asset_name') }}" class="form-control @error('asset_name') is-invalid @enderror" placeholder="Asset Name"  >
                
                        @error('asset_name')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="col-lg-4  mt-2">
                        <label for="asset_file">Asset File </label>                       
                        <input type="file" id="asset_file" name="asset_file" value="{{ old('asset_file') }}" class="form-control @error('asset_file') is-invalid @enderror" placeholder="Asset File"  >
                
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
            <h6 class="m-0 font-weight-bold text-primary">Assets</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Assets Id</th>
                            <th>Assets Name</th>
                            <th>Assets File </th>
                            
                            <th>Active</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @foreach($student_assets as $key => $student_asset)
                        <tr>
                            <td>{{$student_asset->id}}</td>
                            <td>{{$student_asset->asset_name}}</td>
                           
                            <td><a href="{{$student_asset->asset_file}}">Download</a></td>
                            @if($student_asset->is_active==1)
                            <td>Active</td>
                            @else
                            <td>Unactive</td>
                            @endif
                            <td>
                                <a href="javascript:void(0)" type="button" class="student_asset_edit" data-id="{{$student_asset->id}}">Edit</a>
                                <a href="javascript:void(0)" type="button" class="delete" data-id="{{$student_asset->id}}">Delete</a>
                           
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
        var asset_name = $("#asset_name").val();
        var asset_file = $("#asset_file")[0].files[0];
        var assets_id=$('#assets_id').val();
        formData.append('asset_name', asset_name);
        formData.append('id', assets_id);
        formData.append('asset_file', asset_file);
        formData.append('_token', '{{ csrf_token() }}');
        if(asset_name=='' || asset_name==undefined ){
            Swal.fire({
                title: 'Error!',
                text: 'Assets Name is required.', 
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }
        if(asset_file=='' || asset_file==undefined ){
            Swal.fire({
                title: 'Error!',
                text: 'Assets File is required.', 
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }
      
        $.ajax({
            url: '{{ route('student_assets.store') }}',
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

    $(document.body).on('click','.student_asset_edit',function(){
        var student_asset_id=$(this).data('id');
            
            $.ajax({
                    url: '{{ route('student_assets.edit') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: 'GET',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": student_asset_id,
                       
                    },

                    dataType: 'json',
                    success: function (response) {
                       
                        $('#asset_name').val(response.assets.asset_name);
                        $('#assets_id').val(response.assets.id);
                       
                    }
                });

    });

     $('.delete').click(function(e) {
        if(!confirm('Are you sure you want to delete this Course?')) {
            e.preventDefault();
        }
        var student_asset_id=$(this).data('id');
        $.ajax({
            url: '{{ route('student_assets.destroy') }}',
            type: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                "id": student_asset_id,
                       
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