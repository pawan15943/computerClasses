@extends('layouts.student_master')
@section('content')

<div class="container">
<div class="row mt-4 justify-content-center">
    <div class="col-lg-9">
        <div class="accordion" id="editProfile">
            <div class="accordion-item box border-0 mb-3 rounded-2" data-aos="fade-up" data-aos-duration="600">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#personalInfo" aria-expanded="true" aria-controls="collapseOne">
                        Update Profile Info
                    </button>
                </h2>
                <div id="personalInfo" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#editProfile">
                    <div class="accordion-body profile-info">
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-6 mb-3">
                                <span>Student UID</span>
                                <h4>{{$student_profile->student_uid}}</h4>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-6 mb-3">
                                <span>Student's Full Name</span>
                                <h4>{{Auth::user()->name}}</h4>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-6 mb-3">
                                <span>Father Name</span>
                                <h4>{{$user_profile->father_name}}</h4>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-6 mb-3">
                                <span>Gender</span>
                                @if($user_profile->gender=='F')
                                <h4>Female</h4>
                                @elseif($user_profile->gender=='M')
                                <h4>Male</h4>
                                @endif

                            </div>
                            <div class="col-lg-6 col-sm-6 col-6 mb-3">
                                <span>Date of Birth</span>
                                <h4>{{$user_profile->dob}}</h4>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-6 mb-3">
                                <span>Mobile No (Without ISD Code)</span>
                                <h4>{{Auth::user()->phone}}</h4>
                            </div>
                            <div class="col-lg-6 col-sm-12 col-12 mb-3">
                                <span>Email ID</span>
                                <h4>{{Auth::user()->email}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion-item box border-0 mb-3 rounded-2" data-aos="fade-up" data-aos-duration="600">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#addressInfo" aria-expanded="true" aria-controls="collapseOne">
                        Update your Address
                    </button>
                </h2>
                <div id="addressInfo" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#editProfile">
                    <div class="accordion-body profile-info">
                        <div class="row mb-4">

                            <div class="col-lg-6 col-sm-6 col-6 mb-3">
                                <span>Country</span>
                                <h4>{{$user_profile->country_name}}</h4>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-6 mb-3">
                                <span>State</span>
                                <h4>{{$user_profile->state_name}}</h4>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-6 mb-3">
                                <span>City</span>
                                <h4>{{$user_profile->city_name}}</h4>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-6 mb-3">
                                <span>Address</span>
                                <h4>{{Auth::user()->address}}</h4>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <div class="accordion-item box border-0 mb-3 rounded-2" data-aos="fade-up" data-aos-duration="1000">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#listenAboutNBCC" aria-expanded="false" aria-controls="collapseThree">
                        Suggested Location & About ALLEN
                    </button>
                </h2>
                <div id="listenAboutNBCC" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#editProfile">
                    <div class="accordion-body">
                        <div class="row mb-4">
                            <div class="col-lg-6 col-sm-6 col-6 mb-3">
                                <span>Suggestion Method (How you know about NBCC)</span>
                                @if($user_profile->suggestion_method=='1')
                                <h4>Newspaper</h4>
                                @elseif($user_profile->suggestion_method=='2')
                                <h4>Friend Suggestion</h4>
                                @elseif($user_profile->suggestion_method=='3')
                                <h4>Pamphlate</h4>
                                @elseif($user_profile->suggestion_method=='4')
                                <h4>Socail Media</h4>
                                @elseif($user_profile->suggestion_method=='5')
                                <h4>Google Search</h4>
                                @endif
                            </div>
                            <div class="col-lg-6 col-sm-6 col-6 mb-3">
                                <span>Suggested Person Name (If Any)</span>
                                <h4>{{$user_profile->suggested_person_name}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion-item box border-0 mb-3 rounded-2" data-aos="fade-up" data-aos-duration="800">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Select Your Course and Pay
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#editProfile">
                    <div class="accordion-body">

                        @if($student_profile)

                        <div class="row mb-4">
                            <div class="col-lg-6 col-sm-6 col-6 mb-3">
                                <span>Class</span>
                                <h4>{{$student_profile->class_name}}</h4>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-6 mb-3">
                                <span>Course Name</span>
                                <h4>{{$student_profile->course_name}}</h4>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-6 mb-3">
                                <span>Study Center</span>
                                @if($student_profile->center==1)
                                <h4>Kota</h4>
                                @else
                                <h4>Kota</h4>
                                @endif

                            </div>
                            {{-- <div class="col-lg-6 col-sm-6 col-6 mb-3">
                                        <span>Fee Payment Status</span>
                                        @if($transections && $transections->is_varified==1)
                                        <h4>Verified</h4>
                                        @else
                                        <h4>Unverified</h4>
                                        @endif
                                        
                                    </div> --}}
                            <div class="col-lg-6 col-sm-6 col-6 mb-3">
                                <span>Student Status (Verified / Pending)</span>
                                @if($student_profile->is_varified==1)
                                <h4>Verified</h4>
                                @else
                                <h4>Unverified</h4>
                                @endif
                            </div>
                        </div>
                        @else
                        <div class="row mb-4">
                            <div class="col-lg-6 col-sm-6 col-6 mb-3">
                                <span>Class</span>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-6 mb-3">
                                <span>Course Name</span>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-6 mb-3">
                                <span>Study Center</span>

                            </div>
                            <div class="col-lg-6 col-sm-6 col-6 mb-3">
                                <span>Fee Payment Status</span>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-6 mb-3">
                                <span>Student Status (Verified / Pending)</span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>


            <div class="accordion-item box border-0 mb-3 rounded-2" data-aos="fade-up" data-aos-duration="1200">
                <h2 class="accordion-header" id="headingFour">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                        Upload Documents
                    </button>
                </h2>
                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#editProfile">
                    <div class="accordion-body">
                        <div class="row mb-4">
                            <div class="col-lg-6 col-sm-6 col-6 mb-3">
                                <span>Student Profile</span>
                                <h4><img src="{{ asset(Auth::user()->user_photo) }}" alt="Profile" class="rounded-circle" width="100" height="100"></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
@endsection