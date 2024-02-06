@extends('layouts.master')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />               
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Course</h1>
    <div class="card shadow mb-4 py-4">
        <div class="col-lg-12">
            <form id="submit" >
                @csrf
            
                <div class="row g-4">
                    <input type="hidden" name="id" value="" id="course_id">
                   
                    <div class="col-lg-9 mt-3">
                        <input type="text" id="course_name" name="course_name" value="{{ old('course_name') }}" class="form-control @error('course_name') is-invalid @enderror" placeholder="Enter Course Name">
                        @error('course_name')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>

                    <div class="col-lg-3  mt-3">
                        <input type="text" id="course_code" name="course_code" value="{{ old('course_code') }}" class="form-control @error('course_code') is-invalid @enderror" placeholder="Enter Course Code">
                    </div>

                    <div class="col-lg-3  mt-3">
                        <input type="text" id="course_fees" name="course_fees" value="{{ old('course_fees') }}" class="form-control digit-only @error('course_fees') is-invalid @enderror" placeholder="Course Fees">
                    </div>

                    <div class="col-lg-3  mt-3">
                        <input type="text" id="discount_fees" name="discount_fees" value="{{ old('discount_fees') }}" class="form-control @error('discount_fees') is-invalid @enderror" placeholder="Discount Fees">
                    </div>
                    
                    <div class="col-lg-3 mt-3">
                        <input type="text" id="discount" name="discount" value="{{ old('discount') }}" class="form-control digit-only  @error('discount') is-invalid @enderror" placeholder="Discount"  >
                
                    </div>
                    
                    <div class="col-lg-3  mt-3">
                        <input type="text" id="duration" name="duration" value="{{ old('duration') }}" class="form-control @error('duration') is-invalid @enderror" placeholder="Duration"  >
                
                    </div>
                    <div class="col-lg-3  mt-3">
                        <label for="start_date"> Start Date</label>                       
                        <input type="date" id="start_date" name="start_date" value="{{ old('start_date') }}" class="form-control @error('start_date') is-invalid @enderror" placeholder="Discount Fees"  >
                
                    </div>
                    <div class="col-lg-3  mt-3">
                        <label for="end_date"> End Date</label>                       
                        <input type="date" id="end_date" name="end_date" value="{{ old('end_date') }}" class="form-control @error('end_date') is-invalid @enderror" placeholder="End Date"  >
                
                    </div>
                    <div class="col-lg-3  mt-3">
                        <label for="syllabus"> Syllabus</label>                       
                        <input type="file" id="syllabus" name="syllabus" value="{{ old('syllabus') }}" class="form-control @error('syllabus') is-invalid @enderror"  >
                
                    </div>
                    <div class="col-lg-3  mt-3">
                        <label for="shedule"> Sheduled</label>                       
                        <input type="file" id="shedule" name="shedule" value="{{ old('shedule') }}" class="form-control @error('shedule') is-invalid @enderror"  >
                
                    </div>
                    <div class="col-lg-12  mt-3">
                        <button type="submit"  class="btn btn-primary mt-4" >Submit</button>
                    </div>

                </div>
            
            </form>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Courses List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Course Id</th>
                            <th>Course Name</th>
                            <th>Course Code </th>
                            <th>Course Fees </th>
                            <th>Discount</th>
                            <th> Discount Fees </th>
                            <th>Duration</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Active</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @foreach($courses as $key => $course)
                        <tr>
                            <td>{{$course->id}}</td>
                            <td>{{$course->course_name}}</td>
                            <td>{{$course->course_code}}</td>
                            <td>{{$course->course_fees}}</td>
                            <td>{{$course->discount}}</td>
                            <td>{{$course->discount_fees}}</td>
                            <td>{{$course->duration}}</td>
                            <td>{{$course->start_date}}</td>
                            <td>{{$course->end_date}}</td>
                            @if($course->is_active==1)
                            <td>Active</td>
                            @else
                            <td>Unactive</td>
                            @endif
                            <td>
                                <a href="javascript:void(0)" type="button" class="course_edit" data-id="{{$course->id}}">Edit</a>
                                <a href="javascript:void(0)" type="button" class="delete" data-id="{{$course->id}}">Delete</a>
                           
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
       
        var formData = new FormData(this); 
        var course_name = $('#course_name').val();
        var course_code = $('#course_code').val();
        var course_fees = $('#course_fees').val();
        var discount=$('#discount').val();
        var discount_fees=$('#discount_fees').val();
        var duration=$('#duration').val();
        var start_date=$('#start_date').val();
        var end_date=$('#end_date').val();
        var course_id=$('#course_id').val();
        
        
        if(course_code=='' || course_code==undefined ){
            Swal.fire({
                title: 'Error!',
                text: 'Course Code is required.', 
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }
        if(course_name=='' || course_name==undefined ){
            Swal.fire({
                title: 'Error!',
                text: 'Course Name is required.', 
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }
        if(course_fees=='' || course_fees==undefined ){
            Swal.fire({
                title: 'Error!',
                text: 'Course Fees is required.', 
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }
        
        // if(discount_fees=='' || discount_fees==undefined ){
        //     Swal.fire({
        //         title: 'Error!',
        //         text: 'Discount Fees is required.', 
        //         icon: 'error',
        //         confirmButtonText: 'OK'
        //     });
        //     return;
        // }
        if(duration=='' || duration==undefined ){
            Swal.fire({
                title: 'Error!',
                text: 'Duration is required.', 
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }
        if(end_date=='' || end_date==undefined ){
            Swal.fire({
                title: 'Error!',
                text: 'End Date is required.', 
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }
        if(start_date=='' || start_date==undefined ){
            Swal.fire({
                title: 'Error!',
                text: 'Start Date is required.', 
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }
        formData.append('_token', '{{ csrf_token() }}');

            $.ajax({
                url: '{{ route('course.store') }}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                type: 'POST',
                // data: {
                //     "_token": "{{ csrf_token() }}",
                  
                //     course_name: course_name,
                //     course_code: course_code,
                //     course_fees: course_fees,
                //     discount: discount,
                //     discount_fees: discount_fees,
                //     duration: duration,
                //     start_date: start_date,
                //     end_date: end_date,
                //     id: course_id,
                // },
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
                            }).then(function () {
                                location.reload();
                            });
                        } else if (response.errors) {
                          
                            $(".is-invalid").removeClass("is-invalid");
                            $(".invalid-feedback").remove();

                            $.each(response.errors, function (key, value) {
                            
                                $("input[name='" +key+"']").addClass("is-invalid");
                                $("input[name='"+key+"']").after('<span class="invalid-feedback" role="alert">' + value + '</span>');
                             
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

    $(document.body).on('click','.course_edit',function(){
        var course_id=$(this).data('id');  
            $.ajax({
                    url: '{{ route('course.edit') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: 'GET',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": course_id,
                       
                    },

                    dataType: 'json',
                    success: function (response) {
                        
                        $('#course_name').val(response.course.course_name);
                        $('#course_code').val(response.course.course_code);
                        $('#course_fees').val(response.course.course_fees);
                        $('#discount').val(response.course.discount);
                        $('#discount_fees').val(response.course.discount_fees);
                        $('#duration').val(response.course.duration);
                        $('#start_date').val(response.course.start_date);
                        $('#end_date').val(response.course.end_date);
                        $('#course_id').val(response.course.id);
                      
                    }
                });

    });

     $('.delete').click(function(e) {
        if(!confirm('Are you sure you want to delete this Course?')) {
            e.preventDefault();
        }
        var course_id=$(this).data('id');
        $.ajax({
            url: '{{ route('course.destroy') }}',
            type: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                "id": course_id,
                       
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