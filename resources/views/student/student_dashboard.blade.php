@extends('layouts.student_master')
@section('content')

<div class="container dashboard">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <h4 class="m-0 py-3">Course Details</h4>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <th>Course Name</th>
                        <th>Duration</th>
                        <th>Payment Status</th>
                        <th>Mentor Name</th>
                    </tr>
                    <tr>
                        <td>
                            <h4 class="m-0">{{$student_profile->course_name}}</h4>
                        </td>
                        <td>{{$student_profile->duration}} Months</td>
                        <td>
                            @if($student_profile->pending_amount==0)
                            <small class="bg-danger text-white d-inline px-2 py-1 rounded">Pending</small>
                            @else
                            <small class="bg-success text-white d-inline px-2 py-1 rounded">Paid</small>
                            @endif
                            <!-- <small class="bg-success text-white d-inline px-2 py-1 rounded">Verified</small> -->

                        </td>
                        <td>Pawan Rathore</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-9">
            <h4 class="m-0 py-3">Student Corner</h4>
        </div>
    </div>

    <div class="row g-4 justify-content-center">
        <div class="col-lg-3 col-mg-6 col-sm-12">
            <div class="box">
                <img src="assets/images/fact.png" alt="fact" class="img-fluid rounded">
            </div>
        </div>
        <div class="col-lg-3 col-mg-6 col-sm-12">
            <div class="box">
                <h4>Notifications</h4>
                <ul class="list one content">
                    @foreach(auth()->user()->notifications as $notification)
                    <li class="new">
                        <span>{{ $notification['data']['tital'] }},{{ $notification['data']['message'] }}</span>
                        <a href="{{ $notification['data']['url'] }}">Click Here >></a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="col-lg-3 col-mg-6 col-sm-12">
            <div class="box">
                <h4>Free Resources</h4>
                <ul class="list content">
                    <li>
                        <a href="">Global Shortcut Keys</a>
                    </li>
                    <li>
                        <a href="">MS Word Shortcut Keys</a>
                    </li>
                    <li>
                        <a href="">MS Excel Shortcut Keys</a>
                    </li>
                    <li>
                        <a href="">MS Power Point Shortcut Keys</a>
                    </li>
                    <li>
                        <a href="">Google Chrome Shortcut Keys</a>
                    </li>
                    <li>
                        <a href="">All Computer Related Full Forms</a>
                    </li>
                    <li>
                        <a href="">MS Power Point Shortcut Keys</a>
                    </li>
                    <li>
                        <a href="">Google Chrome Shortcut Keys</a>
                    </li>
                    <li>
                        <a href="">All Computer Related Full Forms</a>
                    </li>
                    <li>
                        <a href="">MS Power Point Shortcut Keys</a>
                    </li>
                    <li>
                        <a href="">Google Chrome Shortcut Keys</a>
                    </li>
                    <li>
                        <a href="">All Computer Related Full Forms</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

</div>

</section>
@endsection