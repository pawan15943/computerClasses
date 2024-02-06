<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- view port for responsive layout -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="https://www.allenoverseas.com/images/favicon.png" type="image/png">

    <!-- Page Title -->
    <title>NBCC</title>

    <!-- Meta Description and Keywords -->
    <meta name="description" content="" />
    <meta name="keywords" content="" />
  

    <!-- Site Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Bootstrap Css-->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <!-- Owl Carosal Css-->
    <link rel="stylesheet" href="{{asset('assets/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/owl-theme.css')}}">

    <!-- Site CSS-->
    <link rel="stylesheet" href="{{asset('assets/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/owl-theme.css')}}">

    <!-- Custom Css Files -->
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/responsive-navbar-bv5.css')}}">
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <script src="https://kit.fontawesome.com/aa0a2d735d.js" crossorigin="anonymous"></script>

</head>

<body class="bg-white">

    <div class="login-register-layout">
        <div class="left min-100">
            <img src="{{asset('assets/images/logo/logo.png')}}" alt="logo" class="logo">
        </div>
        <div class="right min-100">
            <div class="contact">
                <p>Mail Us : <a href="mailto:nbcc@gmail.com">nbcc@gmail.com</a> | Call Us : <a
                        href="tel:+91-8114479678">+91-8114479678</a></p>
            </div>
        
            <form method="POST" action="{{ route('login') }}"  id="registerForm">
                    @csrf
                <h2 class="m-0">Log In, Live On.</h2>
                <div class="row g-3">
                    <div class="col-lg-12">
                        <div class="form-floating">
                            <input type="email" class="form-control  @error('email') is-invalid @enderror" placeholder="Email ID"
                            name="email" value="{{ old('email') }}">
                            <label for="floatingInput">Email ID</label>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-floating">
                            <input type="password" class="form-control  @error('password') is-invalid @enderror" placeholder="Password"
                                name="password">
                            <label for="floatingInput">Password</label>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="flexCheckDefault">
                                Remember Me
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-12 mb-4">
                        <button class="btn btn-primary btn-lg">
                            Login
                        </button>
                        {{-- <input type="submit" class="btn btn-primary btn-lg" value="Submit"> --}}
                    </div>
                </div>
            </form>
            <div class="botoom">
                <p class="m-0">If not Register ? <a href="{{('register')}}">Register Here</a></p>
                <p class="m-0"><a href="{{route('password.request')}}">Forgot Password ?</a></p>
            </div>
        </div>
    </div>


    <!-- JQuery file -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>

    <!-- Bootstrap file-->
    <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Owl Js file -->
    <script src="{{asset('assets/js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('assets/js/owl-functions.js')}}"></script>

    <!-- Utilities Js-->
    <script src="{{asset('assets/js/main-js.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js"></script>
    <script>

        $(document).ready(function () {
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

            $("#registerForm").validate({
                rules: {
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
                    },
                    password: {
                        required: true,
                    },
                    confirm_password: {
                        required: true,
                    }
                },
                messages: {

                    name: {
                        required: "Please enter your Full Name",
                        minlength: "Your Name must be at least 3 characters long.",
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
                    },
                    password: {
                        required: "Please enter Password.",
                    },
                    confirm_password: {
                        required: "Please enter your Confirm Password.",
                    }
                },
                errorPlacement: function (error, element) {
                    // Place the error message after the corresponding .form-floating div
                    error.addClass("text-danger small");
                    error.insertAfter(element.closest('.form-floating'));
                },

            });

        });


    </script>

</body>

</html>