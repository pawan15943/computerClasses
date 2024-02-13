
@extends('layouts.student_master')
@section('content')
            <div class="row mt-4 justify-content-center">
                <div class="col-lg-9 ">
                    <ul class="custom-responsive-table">
                        <li class="table-header">
                            <div class="col col-1">Trxn Id</div>
                            <div class="col col-2">Course</div>
                            <div class="col col-3">Fee Type</div>
                            <div class="col col-3">Amount</div>
                            <div class="col col-4">Payment Status</div>
                            <div class="col col-4">Receipt</div>
                        </li>
                        @foreach($my_transactions as $key => $my_transaction)
                        <li class="table-row">
                            <div class="col col-1" data-label="Job Id">{{$my_transaction->transaction_date}}</div>
                            <div class="col col-2" data-label="Customer Name">{{$courses}}</div> 
                            <div class="col col-3" data-label="Amount">
                                @if($my_transaction->installment==0)
                                LumpSum
                                @else
                                Installment {{$my_transaction->installment}}
                                @endif
                               
                            </div>
                            <div class="col col-3" data-label="Amount">{{$my_transaction->received_amount}}</div>
                            <div class="col col-4" data-label="Payment Status"><a href="{{$my_transaction->reciept}}" class="text-red">
                                @if($my_transaction->is_varified==1)
                                Verified
                                @elseif($my_transaction->is_varified==2)
                                Reject
                                @else
                                Pending
                                @endif
                               
                            </a></div>
                            <div class="col col-4" data-label="Receipt"><a href="{{$my_transaction->acknowledgement_receipt}}"><i class="fa fa-download"></i> Download</a> / <a href=""><i class="fa fa-print"></i> Print</a></div>
                        </li>  
                        @endforeach
                    </ul>
                   
                </div>
            </div>
        </div>
    </section>
    @endsection