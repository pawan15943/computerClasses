@extends('layouts.student_master')
@section('content')

    <div class="container">
        <div class="row justify-content-center mt-4">
            <div class="col-lg-9">

                <div class="accordion" id="editProfile">
                    <div class="accordion-item box border-0 mb-3 rounded-2" data-aos="fade-up"
                        data-aos-duration="600">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#personalInfo" aria-expanded="true" aria-controls="collapseOne">
                                Update Profile Info
                            </button>
                        </h2>
                        <div id="personalInfo" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                            data-bs-parent="#editProfile">
                            <div class="accordion-body profile-info">
                                <form id="myForm" >
                                    @csrf
                                    <input type="hidden" value="{{Auth::user()->id}}" id="user_id" name="user_id">
                                    <input type="hidden" value="myForm_id" name="myForm_id">
                                    <div class="row mb-4">
                                        <div class="col-lg-6 mb-3">
                                            <div class="form-floating">
                                                <input type="text" class="form-control char-only"
                                                    placeholder="Student's Full Name" name="name" value="{{Auth::user()->name}}" readonly>
                                                <label for="floatingInput">Student's Full Name</label>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 mb-3">
                                            <div class="form-floating">
                                                <input type="text" class="form-control char-only"
                                                    placeholder="Father Name" name="father_name" id="fatherName" value="@if(old('father_name')){{ old('father_name') }}@elseif(isset($user_profile->father_name)){{$user_profile->father_name}}@endif">
                                                <label for="floatingInput">Father Name</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mb-3">
                                            <div class="form-floating">
                                                <select class="form-select"  name="gender" value="{{ old('gender') }}">
                                                    <option value="">Select Gender</option>
                                                    @if($user_profile)
                                                    <option value="M"  @if($user_profile->gender == "M") {{ "selected" }} @endif>MALE</option>
                                                    <option value="F"  @if($user_profile->gender == "F") {{ "selected" }} @endif>FEMALE</option>
                                                    @else
                                                    <option value="M" >MALE</option>
                                                    <option value="F" >FEMALE</option>
                                                    @endif
                                                </select>
                                                <label for="floatingInput">Gender</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <div class="form-floating">
                                                <input type="date" class="form-control" placeholder="Date of Birth"
                                                    name="dob" value="@if(old('dob')){{ old('dob') }}@elseif(isset($user_profile->dob)){{ $user_profile->dob }}@endif" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                                                    
                                                <label for="floatingInput">Date of Birth *</label>
                                                @error('dob')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <div class="form-floating">
                                                
                                                <input type="text" class="form-control digit-only"
                                                    placeholder="Mobile No" name="phone" minlength="10"
                                                    maxlength="10" readonly value="{{Auth::user()->phone}}">
                                                <label for="floatingInput">Mobile No (Without ISD Code)</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <div class="form-floating">
                                                <input type="email" class="form-control" placeholder="Email Address"
                                                    name="email" readonly id="email" value="{{Auth::user()->email}}">
                                                <label for="floatingInput">Email ID</label>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <input type="submit" class="btn btn-primary" >
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item box border-0 mb-3 rounded-2" data-aos="fade-up"
                        data-aos-duration="600">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#addressInfo" aria-expanded="true" aria-controls="collapseOne">
                                Update your Address
                            </button>
                        </h2>
                        @php
                        $address2 = null; // Initialize $address2 as null
                        if(Auth::user()->address){
                            $address1 = explode(',', Auth::user()->address);
                            // Check if the array key 1 exists before accessing it
                            if(isset($address1[1])){
                                $address2 = explode('-', $address1[1]);
                            }
                        }
                        @endphp
                    
                        <div id="addressInfo" class="accordion-collapse collapse" aria-labelledby="headingOne"
                            data-bs-parent="#editProfile">
                            <div class="accordion-body profile-info">
                                <form action="" id="myForm1">
                                    @csrf
                                    <input type="hidden" value="{{Auth::user()->id}}" id="user_id" name="user_id">
                                    <input type="hidden" value="myForm1" name="myForm_id">

                                    <div class="row mb-4">
                                        <div class="col-lg-4 mb-3">
                                            <div class="form-floating">
                                                <select class="form-select @error('country_id') is-invalid @enderror"
                                                    aria-label="Floating label select example" name="country_id" id="countryid">
                                                    @error('country_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                    @enderror
                                                    <option value="">Select Country</option>
                                                    @if($user_profile)
                                                    @foreach ($countrys as $key => $country)
                                                    <option value="{{$country}}" @if($country == $user_profile->country_id) {{ "selected" }} @endif>{{$key}}</option> 
                                                    @endforeach
                                                    @else
                                                    @foreach ($countrys as $key => $country)
                                                    <option value="{{$country}}" >{{$key}}</option> 
                                                    @endforeach
                                                    @endif
                                                </select>
                                                <label for="floatingSelect">Select Country</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 mb-3">
                                            <div class="form-floating">
                                                <select class="form-select @error('state_id') is-invalid @enderror"
                                                    aria-label="Floating label select example" name="state_id" id="stateid">
                                                    @if($user_profile)
                                                        @foreach ($selectedState as $key => $value)
                                                        <option value="{{$value}}" @if($value == $user_profile->state_id) {{ "selected" }} @endif>{{$key}}</option> 
                                                        @endforeach
                                                        
                                                    @else
                                                    <option value="">Select State</option> 
                                                    @endif
                                                </select>
                                                @error('state_id')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                                <label for="floatingSelect">Select State</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 mb-3">
                                            <div class="form-floating">
                                                <select class="form-select"
                                                    aria-label="Floating label select example"  id="cityid" name="city_id">
                                                    @if($user_profile)
                                                    @foreach ($selectedcity as $key => $value)
                                                    <option value="{{$value}}" @if($value == $user_profile->city_id) {{ "selected" }} @endif>{{$key}}</option> 
                                                    @endforeach
                                                        
                                                    @else
                                                    <option value="">Select City</option>
                                                    @endif
                                                </select>
                                                @error('city_id')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                                <label for="floatingSelect">Select City</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" placeholder="Address Line 1"
                                                    name="address_line_1" value="@if(isset($address1[0])){{$address1[0]}}@endif">
                                                <label for="floatingInput">Address Line 1</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" placeholder="Address Line 2"
                                                    name="address_line_2" value="@if(isset($address2[0])){{$address2[0]}}@endif">
                                                <label for="floatingInput">Address Line 2</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <div class="form-floating">
                                                <input type="text" class="form-control digit-only"
                                                    placeholder="Enter area Pin Code" minlength="6" maxlength="6"
                                                    name="pincode" value="@if(isset($address2[1])){{$address2[1]}}@endif">
                                                <label for="floatingInput">Pin Code</label>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <input type="submit" class="btn btn-primary" value="Update">
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item box border-0 mb-3 rounded-2" data-aos="fade-up"
                        data-aos-duration="1000">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#listenAboutNBCC" aria-expanded="false"
                                aria-controls="collapseThree">
                                Suggested Location & About NBCC
                            </button>
                        </h2>
                        <div id="listenAboutNBCC" class="accordion-collapse collapse" aria-labelledby="headingThree"
                            data-bs-parent="#editProfile">
                            <div class="accordion-body">
                                <form action="" id="myForm2">
                                    @csrf
                                    <input type="hidden" value="{{Auth::user()->id}}" id="user_id" name="user_id">
                                    <input type="hidden" value="myForm2" name="myForm_id">
                                    <div class="row mb-4">
                                        <div class="col-lg-12 mb-3">
                                            <div class="form-floating">
                                                <select class="form-select" name="suggestion_method" >
                                                    <option value="">Select Method</option>
                                                    <option value="1" @if(optional($user_profile)->suggestion_method == 1) {{ "selected" }} @endif>Newspaper</option>
                                                    <option value="2" @if(optional($user_profile)->suggestion_method == 2) {{ "selected" }} @endif>Friend Suggestion</option>
                                                    <option value="3" @if(optional($user_profile)->suggestion_method == 3) {{ "selected" }} @endif>Pamphlet</option>
                                                    <option value="4" @if(optional($user_profile)->suggestion_method == 4) {{ "selected" }} @endif>Social Media</option>
                                                    <option value="5" @if(optional($user_profile)->suggestion_method == 5) {{ "selected" }} @endif>Google Search</option>
                                                </select>
                                                
                                                <label for="floatingInput">How you know about NBCC </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mb-3">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" placeholder="Person name"
                                                    name="suggested_person_name" value="@if(old('suggested_person_name')){{ old('suggested_person_name') }}@elseif(isset($user_profile->suggested_person_name)){{$user_profile->suggested_person_name}}@endif">
                                                <label for="floatingInput">Suggested Person Name (If Any)?</label> 
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <input type="submit" class="btn btn-primary" value="Update">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item box border-0 mb-3 rounded-2" data-aos="fade-up"
                        data-aos-duration="1200">
                        <h2 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                Upload Documents
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                            data-bs-parent="#editProfile">
                            <div class="accordion-body">
                                <form action="" id="myForm4">
                                    @csrf
                                    <input type="hidden" value="{{Auth::user()->id}}" id="user_id" name="user_id">
                                    <input type="hidden" value="myForm4" name="myForm_id">
                                    <div class="row mb-4">
                                        <div class="col-lg-12 mb-3">
                                            <div class="form-floating">
                                                <input type="file" class="form-control @error('user_photo') is-invalid @enderror" id="imageUpload"
                                                    name="user_photo" accept=".png, .jpg, .jpeg">
                                                <label for="" class="default-font">Upload Photo</label>

                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <input type="submit" class="btn btn-primary" value="Update">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item box border-0 mb-3 rounded-2" data-aos="fade-up"
                        data-aos-duration="800">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Select Your Course and Pay
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                            data-bs-parent="#editProfile">
                            <div class="accordion-body">
                                <form action="" id="myForm3">
                                    @csrf
                                    <input type="hidden" value="{{Auth::user()->id}}" id="user_id" name="user_id">
                                    <input type="hidden" value="myForm3" name="myForm_id">
                                    <div class="row mb-4">
                                    <div class="col-lg-12 mb-3">
                                            <div class="form-floating">
                                                <select class="form-select" name="center" required="required">
                                                    <option value="">Please Select Classroom Center</option>
                                                    <option value="1">KOTA</option>
                                                </select>
                                                <label for="floatingInput">Center</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <div class="form-floating">
                                                <select id="class" name="class_id" class="form-select @error('class_id') is-invalid @enderror">
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
                                                <label for="floatingInput">Class</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <div class="form-floating">
                                                
                                                <select id="courseId" name="course_id" class="form-select @error('course_id') is-invalid @enderror">
                                                    <option value="">Please Select Course</option>
                                                    @foreach ($courses as $key => $course)
                                                    <option value="{{$course}}">{{$key}}</option> 
                                                    @endforeach
                                                </select>
                                                @error('course_id')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                                <label for="floatingInput">Course Name</label>
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-4 mb-3" id="total_course_fee">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" 
                                                    value=""  disabled  id="fee_amount" name="fee_amount">
                                                <label for="floatingInput">Total Course Fee</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 mb-3" id="course_code_1">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" 
                                                    value=""  disabled  id="course_code" >
                                                <label for="floatingInput">Course Code</label>
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-4 mb-3 " id="lumpsum_div">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" 
                                                    value=""  disabled  id="lumpsum" >
                                                <label for="floatingInput">LumpSum Amount</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 mb-3 " id="installment1_div">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" 
                                                    value=""  disabled  id="installment1" >
                                                <label for="floatingInput">Installment 1</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 mb-3 " id="installment2_div">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" 
                                                    value=""  disabled  id="installment2" >
                                                <label for="floatingInput"> Installment 2</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 mb-3 " id="installment3_div">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" 
                                                    value=""  disabled  id="installment3" >
                                                <label for="floatingInput">Installment 3</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mb-3 " id="discount_div">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" 
                                                    value=""  disabled  id="discount" >
                                                <label for="floatingInput">Discount Percentage</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <input type="submit" class="btn btn-primary" value="Pay Now">
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

   <!-- Use the full version of jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>

        $(document).ready(function () {
           $('#total_course_fee').hide();
           $('#course_code_1').hide();
           $('#discount_div').hide();
           $('#lumpsum_div').hide();
           $('#installment1_div').hide();
           $('#installment2_div').hide();
           $('#installment3_div').hide();
            $(".char-only").on('keydown', function (e) {
                // Allow only non-digit characters
                if ((e.key >= '0' && e.key <= '9') || /[!@#$%^&*()_+{}\[\]:;<>=`''"",.?~\\/-]/.test(e.key)) {
                    e.preventDefault();
                }
            });

            $(".digit-only").on('keydown', function (e) {
                // Allow digits (0 to 9) and backspace
                if (!((e.key >= '0' && e.key <= '9') || e.key === 'Backspace')) {
                    e.preventDefault();
                }
            });
            // Custom rule for '.com' validation
            $.validator.addMethod("customEmail", function (value, element) {
                return this.optional(element) || /\@.*\.com$/.test(value);
            }, "Email must end with '.com'");

            $("#myForm").validate({
                rules: {
                    father_name: {
                        required: true,
                        minlength: 3,
                        // lettersOnly: true
                    },
                    name: {
                        required: true,
                        minlength: 3
                    },
                    gender: {
                        required: true,
                    },
                    dob: {
                        required: true,
                    },
                    phone: {
                        required: true,
                        minlength: 10,
                        maxlength: 10
                    },
                    email: {
                        required: true,
                        email: true,
                        customEmail: true
                    }
                },
                messages: {
                    father_name: {
                        required: "Please enter your Father Name.",
                        minlength: "Your Father Name must be at least 3 characters long.",
                    },
                    name: {
                        required: "Please enter your Full Name",
                        minlength: "Your Name must be at least 3 characters long.",
                    },
                    gender: {
                        required: "Please Select your Gender.",
                    },
                    dob: {
                        required: "Please Select your Date of Birth.",
                    },
                    phone: {
                        required: "Please enter your Mobile Number.",
                        minlength: "Mobile Number is minimum 10 digit long.",
                        maxlength: "Mobile Number is maximum 10 digit long."

                    },
                    email: {
                        required: "Please enter your Email Address.",
                        email: "Please enter a valid Email Address.",
                        customEmail: "Please Enter Valid Email Address."
                    }
                },
                errorPlacement: function (error, element) {
                    // Place the error message after the corresponding .form-floating div
                    error.addClass("text-danger small");
                    error.insertAfter(element.closest('.form-floating'));
                },

            });

            $("#myForm1").validate({
                rules: {
                    country_id: {
                        required: true,
                    },
                    state: {
                        required: true,
                    },
                    city_id: {
                        required: true,
                    },
                    address_line_1: {
                        required: true,
                    },
                    address_line_2: {
                        required: true,
                    },
                    pincode: {
                        required: true,
                        minlength: 6,
                        maxlength: 6
                    },
                },
                messages: {
                    country_id: {
                        required: "Please select your Country",
                    },
                    state: {
                        required: "Please select your State",
                    },
                    city_id: {
                        required: "Please select your City",
                    },
                    address_line_1: {
                        required: "Please enter Address Line 1",
                    },
                    address_line_2: {
                        required: "Please enter Address Line 2",
                    },
                    pincode: {
                        required: "Please enter your Pin Code.",
                        minlength: "Pin Code is minimum 6 digit long.",
                        maxlength: "Pin Code is maximum 10 digit long."
                    }
                },
                errorPlacement: function (error, element) {
                    // Place the error message after the corresponding .form-floating div
                    error.addClass("text-danger small");
                    error.insertAfter(element.closest('.form-floating'));
                },

            });

            $("#myForm2").validate({
                rules: {
                    suggestion_method: {
                        required: true,
                    },
                  

                },
                messages: {
                    suggestion_method: {
                        required: "Please select your How you know about us.",
                    },
                   
                },
                errorPlacement: function (error, element) {
                    // Place the error message after the corresponding .form-floating div
                    error.addClass("text-danger small");
                    error.insertAfter(element.closest('.form-floating'));
                }

            });

            $("#myForm3").validate({
                rules: {
                    class_id: {
                        required: true,
                    },
                    course_id: {
                        required: true,
                    },
                    center: {
                        required: true,
                    },
                    fee_amount: {
                        required: true,
                    },
                },
                messages: {
                    class_id: {
                        required: "Please select your Class.",
                    },
                    course_id: {
                        required: "Please select your Course.",
                    },
                    center: {
                        required: "Please select your Center for Coaching.",
                    },
                    fee_amount: {
                        required: "Fee Field can't be Empty.",
                    }
                },
                errorPlacement: function (error, element) {
                    // Place the error message after the corresponding .form-floating div
                    error.addClass("text-danger small");
                    error.insertAfter(element.closest('.form-floating'));
                }

            });

            // Add custom validation methods
            $.validator.addMethod('imageFormat', function (value, element) {
                // Validate image format
                var allowedFormats = ['jpeg', 'jpg', 'png', 'gif'];
                var fileExtension = value.split('.').pop().toLowerCase();
                return $.inArray(fileExtension, allowedFormats) !== -1;
            }, 'Invalid image format. Please choose a valid image file.');

            $.validator.addMethod('imageSize', function (value, element, param) {
                // Validate image size (width and height)
                var maxWidth = param[0];
                var maxHeight = param[1];

                var img = new Image();
                img.src = URL.createObjectURL(element.files[0]);

                return img.width <= maxWidth && img.height <= maxHeight;
            }, 'Image size exceeds the allowed dimensions.');

            $("#myForm4").validate({
                rules: {
                    user_photo: {
                        required: true,
                        imageFormat: true,
                        imageSize: [800, 600] // Specify your max width and height here
                    },
                },
                messages: {
                    user_photo: {
                        required: 'Please select an image file.'
                    }
                },
                // submitHandler: function (form) {
                //     // Image is valid, you can submit the form or perform further actions here
                //     alert('Image is valid!');
                // },
                errorPlacement: function (error, element) {
                    // Place the error message after the corresponding .form-floating div
                    error.addClass("text-danger small");
                    error.insertAfter(element.closest('.form-floating'));
                }

            });
            $('#countryid').on('change', function(event){
               
                event.preventDefault();
                var country_id = $(this).val();
                
                if(country_id){
                    $.ajax({
                            url: '{{ route('stateGetConutryWise') }}',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            },
                            type: 'GET',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "country_id": country_id,
                            
                            },

                            dataType: 'json',
                            success: function (html) {
                                console.log(html);
                                if(html){
                                    $("#stateid").empty();
                                    $("#stateid").append('<option value="">Select State</option>');
                                    $.each(html,function(key,value){
                                    
                                        $("#stateid").append('<option value="'+key+'">'+value+'</option>');
                                    });
                                }else{
                                    
                                    $("#stateid").append('<option value="">Select State</option>');
                                }
                                
                                    
                            }
                        });
                }else{
                    $("#stateid").empty();
                    $("#stateid").append('<option value="">Select State</option>');
                }
            });
            
            $('#stateid').on('change', function(event){
                event.preventDefault();
                var state_id = $(this).val();
                if(state_id){
                    $.ajax({
                            url: '{{ route('cityGetStateWise') }}',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            },
                            type: 'GET',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "state_id": state_id,
                            
                            },

                            dataType: 'json',
                            success: function (html) {
                                
                                if(html){
                                    $("#cityid").empty();
                                    $("#cityid").append('<option value="">Select City</option>');
                                    $.each(html,function(key,value){
                                    
                                        $("#cityid").append('<option value="'+key+'">'+value+'</option>');
                                    });
                                }else{
                                    
                                    $("#cityid").append('<option value="">Select City</option>');
                                }
                                
                                    
                            }
                        });
                }else{
                    $("#cityid").empty();
                    $("#cityid").append('<option value="">Select City</option>');
                }
            });
            $(document).on('change','#courseId', function(){
                event.preventDefault();
                var course_id = $(this).val();
                $('#total_course_fee').hide();
                $('#course_code_1').hide();

                $('#discount_div').hide();
                $('#lumpsum_div').hide();
                $('#installment1_div').hide();
                $('#installment2_div').hide();
                $('#installment3_div').hide();
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
                                $('#total_course_fee').show();
                                $('#course_code_1').show();

                              $('#fee_amount').val(html.course_fees);
                              $('#course_code').val(html.course_code);
                              if(html.discount){
                                $('#discount_div').show();
                                $('#discount').val(html.discount);
                                
                              }else{
                                $('#discount_div').hide();
                                
                              }
                              if(html.lumpsum){
                                $('#lumpsum_div').show();
                                $('#lumpsum').val(html.lumpsum);
                                }else{
                                $('#lumpsum_div').hide(); 
                                }
                                if(html.installment_1){
                                    $('#installment1_div').show();
                                    $('#installment1').val(html.installment_1);
                                }else{
                                    $('#installment1_div').hide();
                                }
                                if(html.installment_2){
                                    $('#installment2_div').show();
                                    $('#installment2').val(html.installment_2);
                                }else{
                                    $('#installment2_div').hide();
                                }
                                if(html.installment_3){
                                    $('#installment3_div').show();
                                    $('#installment3').val(html.installment_3);
                                }else{
                                    $('#installment3_div').hide();
                                }
                                    
                            }
                           
                        });
                }
            });
            $(document.body).on('submit', '#myForm, #myForm1, #myForm2, #myForm4', function(event){
               
                event.preventDefault();
               
                var formData = new FormData(this); 
                if(formData){
                   submit_form(formData);

                }
                
            });
            $(document.body).on('submit', '#myForm3', function(event){
               
               event.preventDefault();
               var formData = new FormData(this); 
               if(formData){
                $.ajax({
                        url: '{{ route('profile.store') }}',
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
                                    if(response.student==1){
                                            window.location.href = '{{ route("qrcodeview") }}';
                                      
                                        // window.location.href = '{{ route("studentfees") }}';
                                    }else{
                                        location.reload();
                                    }
                                 
                                });
                            }else if (response.errors) {
                          
                                $(".is-invalid").removeClass("is-invalid");
                                $(".invalid-feedback").remove();

                                $.each(response.errors, function (key, value) {
                                   
                                    $('[name='+ key+']').addClass("is-invalid");
                                    $('[name='+ key+']').after('<span class="invalid-feedback" role="alert">' + value + '</span>');
                                    
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
               }
               
           });

            function submit_form(formData){
                $.ajax({
                        url: '{{ route('profile.store') }}',
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
                                   
                                    $('[name='+ key+']').addClass("is-invalid");
                                    $('[name='+ key+']').after('<span class="invalid-feedback" role="alert">' + value + '</span>');
                                    
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
            }

        });


    </script>
 @endsection