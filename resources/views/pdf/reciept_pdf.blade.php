<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NBCC Fee Receipt Acknowledgement</title>

    <!-- Roboto font -->

    <!-- Pt serif font -->


    <style>
        body {
            font-size: 13px;
            color: #333;
            f
        }

        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 10px 12px;
        }

        td ul>li {
            line-height: 20px;
            margin-bottom: 3px;
            font-size: 13px;
        }

        h2,
        h3,
        h4,
        h5,
        h6 {
            margin: 0px;
        }

        p {
            line-height: 22px;
            font-size: 13px;
        }

        b {
            color: #000;
        }

        .tab_title {
            font-size: 21px;
            font-family: 'PT Serif', serif;
        }

        .logo img {
            margin-top: 15px;
        }

        .text-center {
            text-align: center;
            /* display: block; */
        }

        .text-right {
            text-align: right;
        }

        span.text-center {
            display: block;
        }

        .receipt_header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 30px;
        }

        .address_header h5 {
            color: #000;
            font-size: 15px;
            margin-bottom: 15px;
            font-weight: 500;
        }

        .address_header .address {
            max-width: 270px;
            white-space: wrap;
            margin-left: auto;
            font-size: 14px;
            line-height: 22px;
            margin-bottom: 15px;
        }

        .address_header a {
            color: #333;
            text-decoration: none;
        }

        table::before {
            background-size: 70px;
            position: absolute;
            top: -37%;
            left: -10%;
            content: "";
            width: 200%;
            height: 200%;
            transform: rotate(-10deg);
            opacity: 0.07;
            background-repeat: round;
        }

        table {
            position: relative;
            overflow: hidden;
        }

        .pdf_descContent li,
        .pdf_descContent p {
            line-height: 26px;
        }
    </style>
</head>

<body>
    <div class="recipet_wrapper">

        <!-- header -->
        <div class="receipt_header" style="display: flex; align-items:center;justify-content: space-between;padding-bottom: 30px;">
            <div class="logo" style="display:inline-block; margin-top:15px;">
                <img alt="NBCC Logo">
            </div>
            <div class="address_header text-right" style="margin-top:-80px;">
                <h5>Corporate Office:</h5>
                <div class="address">
                    Unit 408-409, The Business Centre,Khalid Bin Al Waleed Rd<br>
                    Bur Dubai, (near Burjuman Metro station), Dubai
                </div>
                <a href="www.allenoverseas.com" title="Allen overseas">Website : www.allenoverseas.com</a><br>
                <a href="mailto:enquiry@allenoverseas.com" title="Allen overseas">Email : enquiry@allenoverseas.com</a>
            </div>
        </div>
        <!-- Main content-->
        <table class="table table-bordered">
        <thead class="text-center">
            <tr>
                <th colspan="8" class="tab_title">Fee Acknowledgement Receipt - Academic Session :
                    Session
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="width:30%"><b>Student UID No.</b></td>
                <td style="width:15%">
                    @if($user->student_uid !=null)
                    {{$user->student_uid}}
                    @endif

                </td>
                <td><b>Candidate Name:</b></td>
                <td colspan="5">
                    {{$user->name}}
                </td>

            </tr>
            <tr>
                <td><b>Invoice Reference No. </b></td>
                <td colspan="7">
                    {{$pdf_name}}

                </td>

            </tr>
            <tr>
                <td><b>Intallment </b></td>
                @foreach($transactons as $key => $transacton)
                <td>
                    @if($transacton->installment==0)
                    LumpSum 
                    @else
                    Intallment {{$transacton->installment}}  
                    @endif
                    -{{$transacton->received_amount}}
                <td>
                    @if($transacton->is_varified==1)
                    <b> Verified</b>
                    @else
                    <b>Unverified</b>
                    @endif
                </td>
                @endforeach
                </td>
            </tr>
            <tr>
                <td><b>Transaction Date:</b></td>
                @foreach($transactons as $key => $transacton)
                <td colspan="7">

                    {{$transacton->transaction_date}}
                </td>
                @endforeach
            </tr>
            <tr>
                <td><b>Father's Name:</b></td>
                <td colspan="7">
                    {{$user->father_name}}
                </td>
            </tr>
            <tr>
                <td><b>Course:</b></td>
                <td colspan="7">
                    {{ $student->course_name}}
                </td>
            </tr>
            <tr>
                <td><b>Duration:</b></td>
                <td colspan="7">
                    {{ $student->duration}}
                </td>
            </tr>
            <tr>
                <td><b>Total Course Fees:</b></td>
                <td>
                    {{ $student->total_course_fees}}
                </td>
                <td><b>Amount Received:</b></td>
                <td>
                    {{ $student->paid_amount}}
                </td>
                <td><b>Amount Pending:</b></td>
                <td>
                    {{ $student->pending_amount}}
                </td>
                @if($student->discount !=null)
                <td><b>Discount:</b></td>
                <td>
                    {{ $student->discount}}
                </td>
                @endif
            </tr>

            <tr>
                <td colspan="8" class="pdf_descContent">
                    <h4 class="text-left">Undertaking</h4>


                    <p>I hereby declare that I have read all the instructions in 'INFORMATION BULLETIN / available
                        at the website
                        <a href="https://www.allenoverseas.com/terms-and-conditions" target="_blank">ALLEN Overseas: Terms and Conditions</a> and I do agree to follow the same
                        and as applicable time
                        to time.
                    </p>
                    <p>I also agree to abide by the <a href="https://www.allenoverseas.com/refund-cancellation/" target="_blank">Refund Rules of the Institute</a>. All disputes are subject to
                        UAE(Dubai) Jurisdiction only.</p>
                </td>
            </tr>
            <tr>

                <td colspan="8">
                    <h4 class="text-left">Terms & Conditions</h4>
                    <ul class="pdf_descContent">
                        <li>This is not a VAT Invoice.</li>
                        <li>VAT Invoice Cum Receipt will be uploaded on student portal within 30 days.</li>
                        <li>This is a computer-generated acknowledgement; hence no signature is required.</li>
                        <li>The first installment and the subsequent installments of the course fee paid by you for
                            enrolling in the ALLEN Overseas Classroom Program are non-refundable. You acknowledge
                            that because of any reason whatsoever, you decide not to continue with your classes for
                            the academic year that you have enrolled for, You will not be entitled to any refund
                            from ALLEN Overseas or any of its partners/subsidiaries/associates/third-party service
                            providers.</li>
                        <li>1st installment to be paid at the time of enrollment. 2nd installment to be paid within
                            45 days from course commencement date.</li>
                    </ul>

                    <h4 class="text-left">Refund Rules</h4>
                    <ul class="pdf_descContent">
                        <li>We at ALLEN would like to inform you that we have a strict NO REFUND / MONEY RETURN / ADMISSION CANCELLATION POLICY regarding all matters of monetary transactions. Once the payment is made, it will not be returned or refunded under any circumstances.
                        </li>
                    </ul>

                </td>
            </tr>

        </tbody>
    </table>

    </div>

</body>

</html>