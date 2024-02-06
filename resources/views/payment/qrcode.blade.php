@extends('layouts.student_master')
<style>
    .custom-radio {
        display: inline-block;
        position: relative;
        padding-left: 30px;
        cursor: pointer;
        border: 2px solid transparent;
        border-radius: 5px;
        margin-right: 10px;
    }

    .custom-radio input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 20px;
        width: 20px;
        background-color: #eee;
        border-radius: 50%;
    }

    .custom-radio input:checked~.checkmark {
        background-color: #2196F3;
    }

    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    .custom-radio input:checked~.checkmark:after {
        display: block;
    }

    .custom-radio .checkmark:after {
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #fff;
    }
</style>
@section('content')
<div class="container">
    <div class="row justify-content-center mt-4">
        <div class="col-lg-9">

            <div class="accordion" id="editProfile">
                <div class="accordion-item box border-0 mb-3 rounded-2" data-aos="fade-up" data-aos-duration="600">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#personalInfo" aria-expanded="true" aria-controls="collapseOne">
                            Select Payment Option & Scan QR Code
                        </button>
                    </h2>
                    <div id="personalInfo" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#editProfile">
                        <div class="accordion-body profile-info">
                            @php
                            $paymentOption=App\Models\Student::where('user_id',Auth::user()->id)->whereNotNull('payment_option')->first();

                            @endphp
                            <form id="submit">
                                @csrf
                                <input type="hidden" value="{{Auth::user()->id}}" id="user_id" name="user_id">
                                <input type="hidden" value="myForm_id" name="myForm_id">
                                <div class="row mb-4">
                                    @if($paymentOption && $paymentOption->payment_option=='installment')
                                    <div class="col-lg-6 mb-3">
                                        <label class="custom-radio">
                                            <input type="radio" name="paymentOption" value="installment" onclick="showInstallmentOptions()" id="pay_installment"> Pay By Installment
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    @elseif($paymentOption && $paymentOption->payment_option=='lumpSum')
                                    <div class="col-lg-6 mb-3">
                                        <label class="custom-radio">
                                            <input type="radio" name="paymentOption" value="lumpSum" id="pay_lumpSum"> Pay by LumpSum
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    @else
                                    <div class="col-lg-6 mb-3">
                                        <label class="custom-radio">
                                            <input type="radio" name="paymentOption" value="installment" onclick="showInstallmentOptions()" id="pay_installment"> Pay By Installment
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label class="custom-radio">
                                            <input type="radio" name="paymentOption" value="lumpSum" id="pay_lumpSum"> Pay by LumpSum
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    @endif

                                </div>
                                <div class="installment-options">

                                    <div class="row">
                                        <div class="col-lg-4 mb-3">
                                            <label class="installment-option-label">
                                                <input type="radio" name="installment" value="1"> Installment 1:
                                                <input type="text" class="form-control" name="installment1" id="installment1" readonly>
                                            </label>
                                        </div>
                                        <div class="col-lg-4 mb-3">
                                            <label class="installment-option-label">
                                                <input type="radio" name="installment" value="2"> Installment 2:
                                                <input type="text" class="form-control" name="installment2" id="installment2" readonly>
                                            </label>
                                        </div>
                                        <div class="col-lg-4 mb-3">
                                            <label class="installment-option-label">
                                                <input type="radio" name="installment" value="3"> Installment 3:
                                                <input type="text" class="form-control" name="installment3" id="installment3" readonly>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="lumpsum ">
                                    <div class="col-lg-6 mb-3">
                                        <input type="text" class="form-control digit-only" name="lumpsum_amt" value="" id="lumpsum_amt" readonly>
                                    </div>

                                </div>
                                <div class="col-lg-12 mb-3">
                                    <img src="img/qrcode.png" alt="QR Code" width="300" height="300">
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-6 mb-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control " placeholder="Transaction ID" name="transaction_id" value="">
                                            <label for="floatingInput">Transaction ID</label>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 mb-3">
                                        <div class="form-floating">

                                            <input type="date" class="form-control digit-only" placeholder="Transaction Date" name="transaction_date" value="">
                                            <label for="floatingInput">Transaction Date</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mb-3">
                                        <div class="form-floating">
                                            <input type="file" class="form-control @error('reciept') is-invalid @enderror" id="imageUpload" name="reciept" accept=".png, .jpg, .jpeg">
                                            <label for="" class="default-font">Upload reciept</label>

                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <input type="submit" class="btn btn-primary">
                                    </div>

                                </div>

                            </form>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
</section>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<!-- Utilities Js-->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.7/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.7/dist/sweetalert2.all.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('.installment-options').hide();
        $('.lumpsum').hide();

        $(document).on('click', '#pay_installment', function() {
            $('.installment-options').show();
            $('.lumpsum').hide();
            $.ajax({
                url: '{{ route("getUsereWiseFees") }}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                type: 'GET',
                data: {
                    "_token": "{{ csrf_token() }}",

                },

                dataType: 'json',
                success: function(html) {
                    console.log(html);
                    $('#installment1').val(html.installment_1);
                    $('#installment2').val(html.installment_2);
                    $('#installment3').val(html.installment_3);
                }
            });

        });
        $(document).on('click', '#pay_lumpSum', function() {
            $('.lumpsum').show();
            $('.installment-options').hide();
            $.ajax({
                url: '{{ route("getUsereWiseFees")}}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                type: 'GET',
                data: {
                    "_token": "{{ csrf_token() }}",

                },

                dataType: 'json',
                success: function(html) {
                    $('#lumpsum_amt').val(html.lumpsum);
                }
            });
        });


        $(document.body).on('submit', '#submit', function(event) {

            event.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: '{{ route("studentfees.store") }}',
                type: 'POST',
                data: formData,

                processData: false,
                contentType: false,

                dataType: 'json',
                success: function(response) {

                    if (response.success) {
                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success'
                        }).then(function() {
                            window.location.href = '{{ route("home") }}';
                            //    location.reload();

                        });
                    } else if (response.errors) {

                        $(".is-invalid").removeClass("is-invalid");
                        $(".invalid-feedback").remove();

                        $.each(response.errors, function(key, value) {

                            $('[name=' + key + ']').addClass("is-invalid");
                            $('[name=' + key + ']').after('<span class="invalid-feedback" role="alert">' + value + '</span>');

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

    });
</script>
@endsection