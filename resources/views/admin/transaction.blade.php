@extends('layouts.master')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />               
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Payment Transaction</h1>
   
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Transaction List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Trans Id</th>
                            <th>Student Id</th>
                            <th>Fees</th>
                            <th>Trans Date</th>
                            <th>Verified</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @foreach($transections as $key => $value)
                        <tr>
                            <td>{{$value->id}}</td>
                            <td>{{$value->student_id}}</td>
                            <td>{{$value->received_amount}}</td>
                            <td>{{$value->transaction_date}}</td>
                           
                            @if($value->is_varified==1)
                            <td>Verified</td>
                            @else
                            <td>UnVerified</td>
                            @endif
                            <td>
                                <a href="javascript:void(0)" type="button" data-toggle="modal" data-target="#exampleModalCenter" class="trans_view" data-id="{{$value->id}}"  data-stuId="{{$value->student_id}}">View</a>
                                <a href="javascript:void(0)" class="btn btn-info m-2 approve"  data-toggle="tooltip" class="btn btn-info m-2" data-id="{{$value->id}}">Approve</a>
                            </td>
                        </tr>
                        @endforeach
                    
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Transaction Detail</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="row">
          
            <span class="pr-2">Student ID </span> : <h6 class="pl-2" id="Student_id"></h6>
            </div>
            <div class="row">
            <span class="pr-2">Student Name</span> : <h6 class="pl-2" id="name"></h6>
            </div>
            <div class="row">
            <span class="pr-2">Email</span> : <h6 class="pl-2" id="email"></h6>
            </div>
            <div class="row">
                <span class="pr-2">Phone</span> : <h6 class="pl-2" id="phone"></h6>
            </div>
            <div class="row">
                <span class="pr-2">Fees</span> : <h6 class="pl-2" id="fees"></h6>
                </div>
                <div class="row">
                    <span class="pr-2">Received Amount</span> : <h6 class="pl-2" id="received_amount"></h6>
                    </div>
            <div class="row">
            <span class="pr-2">Transaction Id</span> : <h6 class="pl-2" id="payme_id"></h6>
            </div>
            <div class="row">
            <span class="pr-2">Transaction date</span> : <h6 class="pl-2" id="trans_date"></h6>
            </div>
            <div class="row">
            <span class="pr-2">Course</span> : <h6 class="pl-2" id="stu_course"></h6>
            </div>
            <div class="row">
                <span class="pr-2">Reciept</span> : <a class="pl-2" id="trans_reciept" download>Download</a>
                </div>
        </div>
        <div class="modal-footer">
          {{-- <button type="button" class="btn btn-success btn-circle btn-lg verified_true"> <i class="fas fa-check"></i></button>
          <button type="button" class="btn btn-success btn-circle btn-lg verified_decline"> <i class="fas fa-close"></i></button> --}}
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
        </div>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
  
  <script type="text/javascript">
    $(document.body).on('click','.trans_view',function(){
        var trans_id=$(this).data('id');
        var student_id = $(this).attr('data-stuId');
        $('#Student_id').text(student_id);

            $.ajax({
                    url: '{{ route('transaction.view') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: 'GET',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": trans_id,
                        "student_id": student_id,
                       
                    },

                    dataType: 'json',
                    success: function (response) {
                       
                        $('#name').text(response.data.name);
                        $('#email').text(response.data.email);
                        $('#phone').text(response.data.phone);
                        $('#stu_course').text(response.course.course_name);
                        $('#payme_id').text(response.transaction.transaction_id);
                        $('#fees').text(response.transaction.fee_amount);
                        $('#received_amount').text(response.transaction.received_amount);
                        $('#trans_date').text(response.transaction.transaction_date);
                        $('#trans_reciept').attr('href', response.transaction.reciept);
                       
                      
                    }
                });
        
    });

    $(document.body).on('click','.approve',function() {
            var token = $("meta[name='csrf-token']").attr("content");
            var id = $(this).data("id");
           
            var value = $(this).data("value");
            event.preventDefault();
            Swal.fire({
                title: 'Approve Record',
                text: "Approve/Decline this record",
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText:`<i class="fa fa-thumbs-up"></i>`,
                denyButtonText: `<i class="fa fa-thumbs-down"></i>`
               
            }).then((result) => {
                if (result.isConfirmed) {
                    var verification_id=1;
                    verified(id,verification_id);
                } else if (result.isDenied) {
                    var verification_id=2;
                    verified(id,verification_id);
                }
              
            });
        });


    function verified(id,verification_id){
        $.ajax({
                    url: '{{ route('paymentVerifyStatus') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: 'GET',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "verification_id": verification_id,
                        "id": id,
                       
                    },

                    dataType: 'json',
                    success: function (response) {
                                 Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Record approved successfully.',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                       
                      
                    }
                });
    }
  </script>          
@endsection