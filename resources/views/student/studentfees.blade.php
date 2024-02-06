<!-- currently this page not use -->
@extends('layouts.master')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}" />               
<div class="container-fluid">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="text-center ">
            <h4 class="mt-4">Student Fees</h4>
            </div>
            <form id="submit">    
                @csrf
                <input type="hidden" value="{{Auth::user()->id}}" id="user_id" name="user_id">
             
                    <div class="row">

               
                        <div class="p-5">
                           
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <select id="class" name="class_id" class="form-control @error('class_id') is-invalid @enderror">
                                        @error('class_id')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                        <option value="">Select Class</option>
                                        @foreach ($classes as $key => $class)
                                        <option value="{{$class}}"  >{{$key}}</option> 
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <select id="courseId" name="course_id" class="form-control @error('course') is-invalid @enderror">
                                        @error('course')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                        <option value="">Select Course</option>
                                        @foreach ($courses as $key => $course)
                                        <option value="{{$course}}"  >{{$key}}</option> 
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="text" class="form-control form-control-user" id="fee_amount" name="fee_amount"
                                        placeholder="Fee Amount" value="" readonly>
                                </div>
                                <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-user" id="course_code" 
                                            placeholder="Course Code" value="" readonly>
                                </div>
                            </div>
                            <label class="mr-2">Is Certificate Issued</label>
                            <input type="radio" class="is_certificate" name="is_certificate" value="1" >
                            <label for="is_certificate">Yes</label>
                            <input type="radio"  class="is_certificate" name="is_certificate" value="0" >
                            <label for="is_certificate">No</label>
                        </div>
                            
                
           
            </div>
            <div class="text-center ">
            <button type="submit"  class="btn btn-primary btn-user mb-4" >Pay Now</button>
            </div>
            </form>
        </div>
    </div>
</div>
<div id="qrcode-container"></div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
 
    $(document).ready(function() {
            $(document).on('change','#courseId', function(){
                event.preventDefault();
                var course_id = $(this).val();
            
                if(course_id){
                    $.ajax({
                            url: '{{ route('getCourseWiseFees') }}',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            },
                            type: 'GET',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "course_id": course_id,
                            
                            },

                            dataType: 'json',
                            success: function (html) {
                             
                              $('#fee_amount').val(html.course_fees);
                              $('#course_code').val(html.course_code);
                                    
                            }
                        });
                }
            });
           
            $(document.body).on('submit', '#submit', function(event){
                event.preventDefault();
                var formData = new FormData(this); 
               
                
                $.ajax({
                        url: '{{ route('studentDetail.store') }}',
                        type: 'POST',
                        data:formData,
                        
                        processData: false,
                        contentType: false,

                        dataType: 'json',
                            success: function (html) {
                                if (html.success){
                                    window.location.href = '{{ route("qrcodeview") }}';
                                   
                                }
                                
                            }
                        });

            });
            // $(document).on('click','#pay', function(){
            //     event.preventDefault();
            //     var user_id = $('#user_id').val();
                
            //     $.ajax({
            //                 url: '{{ route('initiatePayment') }}',
            //                 headers: {
            //                     'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            //                 },
            //                 type: 'GET',
            //                 data: {
            //                     "_token": "{{ csrf_token() }}",
            //                     "user_id": user_id,
                            
            //                 },

            //                 dataType: 'json',
            //                 success: function (html) {
            //                     if (html.success){
            //                         // var qrcodeContainer = $('#qrcode-container');
                                    
            //                         window.location.href = '{{ route("qrcodeview") }}';
            //                         // Set the src attribute of the img tag with the Google Charts API URL
            //                         // qrcodeContainer.html('<img src="' + html.qrCodeUrl + '" alt="' + html.qrCodeUrl + '">');
            //                     }
                                
            //                 }
            //             });

            // });
        
        });
</script>

 @endsection
 