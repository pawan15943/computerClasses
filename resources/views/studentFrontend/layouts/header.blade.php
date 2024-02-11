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
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Bootstrap Css-->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <!-- Owl Carosal Css-->
    <link rel="stylesheet" href="{{asset('assets/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/owl-theme.css')}}">
    <!-- Site CSS-->
    <!-- Sweet Alert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.7/dist/sweetalert2.min.css">

    <!-- Custom Css Files -->
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/responsive-navbar-bv5.css')}}">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <script src="https://kit.fontawesome.com/aa0a2d735d.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css" />

</head>

<body>
    <!-- Header Starts Here -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-white border-0 ">
            <div class="container">
                <a class="navbar-brand" href="{{route('home')}}">
                    <img src="{{asset('assets/images/logo/logo.png')}}" alt="Logo" class="logo">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="{{route('notification_list')}}" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-bell"></i> Notification {{ auth()->user()->unreadNotifications->count() }}
                            </a>
                            <ul class="dropdown-menu w-22 notific-dropdown" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item text-center bg-light" href="{{route('notification_list')}}">Notification List</a></li>
                                @foreach(auth()->user()->unreadNotifications as $notification)
                                <li class="notification">
                                    <a class="dropdown-item mark-as-read" data-notification-id="{{ $notification->id }}" href="{{ $notification['data']['url'] }}">
                                        <div class="small text-gray-500"><i class="fa fa-bell pe-2"></i>
                                            {{ $notification['data']['tital'] }}
                                        </div>
                                        <span class="font-weight-bold">{{ $notification['data']['message'] }}</span>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="{{route('home')}}" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Welcome <b><i class="fa fa-user-circle"></i> {{Auth::user()->name}}</b>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="{{route('home')}}"><i class="fa fa-dashboard pe-2"></i>
                                        Dashboard</a></li>
                                {{-- <li><a class="dropdown-item" href="scholarships.html"><i class="fa fa-percentage pe-2"></i> Scholarship & Discounts</a></li> --}}
                                <li><a class="dropdown-item" href="{{route('my_transaction')}}"><i class="fa fa-credit-card pe-2"></i> My Transactions</a></li>
                                <li><a class="dropdown-item" href="{{route('change-password')}}"><i class="fa fa-key pe-2"></i>
                                        Change Password</a></li>
                                <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out pe-2"></i>
                                        Logout</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <!-- header ends Here -->


    <!-- Inner Pages Heder -->
    <div class="header-section-inner" style="background: #ababab url({{asset('assets/images/bg-texture.png')}}); background-size: 30%; background-repeat: repeat-x; background-position: bottom;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="header-box justify-content-center"> 
                        @if(Route::currentRouteName()=='home')
                        <h1>Dashboard</h1>
                        @elseif(Route::currentRouteName()=='profile')
                        <h1>Edit Profile</h1>
                        @elseif(Route::currentRouteName()=='notification_list')
                        <h1>Notifications</h1>
                        @elseif(Route::currentRouteName()=='qrcodeview')
                        <h1>Pay Now</h1>
                       
                        @elseif(Route::currentRouteName()=='my_transaction')
                        <h1>My Transection</h1>
                        @elseif(Route::currentRouteName()=='change-password')
                        <h1>Change Password</h1>
                        @elseif(Route::currentRouteName()=='profile.show')
                        <h1>View Profile</h1>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- We get Profile Completion Percenttage -->
    @php
    $completePro=App\Models\Student::where('user_id',Auth::user()->id)->whereNotNull('course_id')->count();
    $uncompletePro=App\Models\Profile::where('user_id',Auth::user()->id)->count();
    $completionPercentage = 0;
    if ($completePro > 0 && $uncompletePro>0) {
    $completionPercentage = 100;
    } elseif ($uncompletePro > 0) {
    $completionPercentage = 50;
    } else {
    $completionPercentage = 30;
    }

    @endphp
    <!-- End -->
 
    <!-- Student Profile Section Starts Here -->

    <section class="pt-5 pb-5 content-section position-relative">
        <!-- Rangoli Image -->
        <img src="{{asset('assets/images/rangoli-bg.png')}}" alt="rajasthan-rangoli" class="rangoli">
        <div class="container">
            <!-- Profile -->
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <nav aria-label="breadcrumb d-inline">
                        <ol class="breadcrumb">
                            @if(Route::currentRouteName()=='home')
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                            @else
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                                @if(Route::currentRouteName()=='qrcodeview')
                                <li class="breadcrumb-item active" aria-current="page">Pay Now</li>
                                @elseif(Route::currentRouteName()=='my_transaction')
                                <li class="breadcrumb-item active" aria-current="page">My Transactions</li>   
                                @elseif(Route::currentRouteName()=='change-password')
                                <li class="breadcrumb-item active" aria-current="page">Change Password</li>   
                                @elseif(Route::currentRouteName()=='profile.show')
                                <li class="breadcrumb-item active" aria-current="page">View Profile</li>   
                                @endif
                            
                            @endif   
                        </ol>
                    </nav>
                    @if($completionPercentage==100)
                    
                    <a href="{{route('profile.show')}}" class="add-profile box py-2 px-3 float-end d-inline"><i class="las la-plus"></i> View Profile</a>
                    @else
                    <a href="{{route('profile')}}" class="add-profile box py-2 px-3 float-end d-inline"><i class="las la-plus"></i> Edit Profile</a>
                    @endif
                </div>
            </div>
            @if(Route::currentRouteName()=='home' || Route::currentRouteName()=='profile' || Route::currentRouteName()=='profile.show' || Route::currentRouteName()=='qrcodeview')

            <div class="row mt-4 justify-content-center">
                <div class="col-lg-9">
                    <!-- Stduent Profile -->
                    <div class="profile-design box mb-3" data-aos="fade-up" data-aos-duration="400">
                        <div class="row">
                            <div class="uppersec"></div>
                        </div>
                        <div class="lowersec">
                            <div class="p-4 mt-negative">
                                <div class="row">
                                    <div class="col-lg-2 ">
                                        <div class="position-relative w-130">
                                            @if($user_profile)
                                            @php
                                            if(Auth::user()->user_photo !=null){
                                            $photo = Auth::user()->user_photo;
                                            }elseif(Auth::user()->user_photo == null && $user_profile->gender == 'M') {
                                            $photo = "img/male.png";
                                            } elseif (Auth::user()->user_photo == null && $user_profile->gender == 'F') {
                                            $photo = "img/female.png";
                                            } else {
                                            $photo = "img/male.png";
                                            }
                                            @endphp
                                            <img src="{{ asset($photo) }}" alt="Profile" class="rounded-circle" width="100" height="100">
                                            @else
                                            <img src="assets/images/profile.jpg" alt="Profile" class="rounded-circle">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-10 ">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <h4 class="text-white st-profile-name ml-auto">{{Auth::user()->name}}</h4>
                                        </div>
                                    </div>
                                    <div class="col-lg-2"></div>
                                    @php
                                    $student = App\Models\Student::where('user_id', Auth::user()->id)->first();
                                    if($student != null){
                                    $transections = DB::table('transaction')->where('student_id', $student->id)->get();
                                    $transection_count = $transections->count();
                                    $lastTransaction = $transections->last();
                                    }else{
                                        $transections=null;
                                    }
                                    @endphp
                                    <div class="col-lg-10">
                                        <div class="profile-status">
                                            <div class="row justify-content-end">
                                                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mt-3 mt-md-0">
                                                    <div class="card-shadow-danger widget-chart widget-chart2">
                                                        <div class="widget-content">
                                                            <div class="widget-content-outer">
                                                                <div class="widget-content-wrapper">

                                                                    <div class="widget-content-left pr-2 fsize-1">
                                                                        <span class="widget-numbers mt-0 fsize-3 text-primary">
                                                                            Profile Complete: {{ $completionPercentage }}%
                                                                        </span>
                                                                    </div>
                                                                    <div class="widget-content-right w-100 mt-2">
                                                                        <div class="progress-bar-xs progress">
                                                                            <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: {{ $completionPercentage }}%;"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if($transections!=null && $transection_count!=0)
                                                @php
                                                $lastTransactionDate = strtotime($lastTransaction->transaction_date);
                                                $dueDate2 = strtotime('+20 days', $lastTransactionDate);
                                                $dueDate3 = strtotime('+40 days', $lastTransactionDate);
                                                @endphp
                                                @if($transection_count==1 && $student_profile->payment_option=='installment')
                                                    @foreach($transections as $key => $transection)
                                                    <div class="col-lg-3 col-md-6 col-sm-6 col-12 mt-3 mt-md-0">
                                                        <span>1st Instalment Paid On :</span>
                                                        <h4 class="text-success"><i class="fa fa-calendar"></i>  {{$transection->transaction_date}}
                                                            <a href="{{$transection->acknowledgement_receipt}}" class=" action-edit-pro-file" download=""><i class="fa fa-download"></i> Receipt</a>
                                                        </h4>
                                                    </div>
                                                    @endforeach
                                                    <div class="col-lg-3 col-md-6 col-sm-6 col-12 mt-3 mt-md-0">
                                                        <span>2nd Installment Due On :</span>
                                                        <h4 class="text-danger"><i class="fa fa-calendar"></i> {{ date('Y-m-d', $dueDate2) }}<a href="{{ route("qrcodeview") }}" class=" action-edit-pro-file"> Pay Now <i class="las la-angle-right"></i></a>
                                                        </h4>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 col-sm-6 col-12 mt-3 mt-md-0">
                                                        <span>3rd Installment Due On :</span>
                                                        <h4 class="text-danger"><i class="fa fa-calendar"></i> {{ date('Y-m-d', $dueDate3) }}<a href="{{ route("qrcodeview") }}" class="action-edit-pro-file"> Pay Now <i class="las la-angle-right"></i></a>
                                                        </h4>
                                                    </div>
                                                @elseif($transection_count==2 && $student_profile->payment_option=='installment')
                                                    @foreach($transections as $key => $transection)

                                                    <div class="col-lg-3 col-md-6 col-sm-6 col-12 mt-3 mt-md-0">
                                                        <span> {{$key+1}} Instalment Paid On :</span>
                                                        <h4 class="text-success"><i class="fa fa-calendar"></i> {{$transection->transaction_date}}
                                                            <a href="{{$transection->acknowledgement_receipt}}" class="action-edit-pro-file" download=""><i class="fa fa-download"></i> Receipt</a>
                                                        </h4>
                                                    </div>

                                                    @endforeach
                                                <div class="col-lg-3 col-md-6 col-sm-6 col-12  mt-md-0">
                                                    <span>3rd Installment Due On :</span>
                                                    <h4 class="text-danger"><i class="fa fa-calendar"></i> {{ date('Y-m-d', $dueDate3) }}<a href="{{ route("qrcodeview") }}" class="action-edit-pro-file"> Pay Now <i class="las la-angle-right"></i></a>
                                                    </h4>
                                                </div>
                                                @elseif($transection_count==3 && $student_profile->payment_option=='installment')
                                                    @foreach($transections as $key => $transection)

                                                    <div class="col-lg-3 col-md-6 col-sm-6 col-12 mt-3 mt-md-0">
                                                        <span> {{$key+1}} Instalment Paid On :</span>
                                                        <h4 class="text-success"><i class="fa fa-calendar"></i> {{$transection->transaction_date}}
                                                            <a href="{{$transection->acknowledgement_receipt}}" class=" action-edit-pro-file" download=""><i class="fa fa-download"></i> Receipt</a>
                                                        </h4>
                                                    </div>
                                                    @endforeach
                                                @elseif($transection_count==1 && $student_profile->payment_option=='lumpSum')
                                                    @foreach($transections as $key => $transection)
                                                    <div class="col-lg-3 col-md-6 col-sm-6 col-12 mt-3 mt-md-0">
                                                        <span> Fees Paid On :</span>
                                                        <h4 class="text-success"><i class="fa fa-calendar"></i> {{$transection->transaction_date}}
                                                            <a href="{{$transection->acknowledgement_receipt}}" class="ps-2 action-edit-pro-file" download=""><i class="fa fa-download"></i> Receipt</a>
                                                        </h4>
                                                    </div>
                                                    @endforeach
                                                @endif
                                                @else
                                                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mt-3 mt-md-0">
                                                    @if(!empty($user_profile->updated_at))
                                                    <span>Installment Due On :</span>
                                                   
                                                    <h4 class="text-danger"><i class="fa fa-calendar"></i> {{ \Carbon\Carbon::parse($user_profile->updated_at)->format('d-m-Y') }}<a class="ps-2 action-edit-pro-file"> Pay Now <i class="las la-angle-right"></i></a>
                                                    </h4>
                                                   
                                                    @endif
                                                </div>
                                                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mt-3 mt-md-0">
                                                </div>
                                                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mt-3 mt-md-0">
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif