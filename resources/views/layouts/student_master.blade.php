@include('studentFrontend.layouts.header')
@php
$completePro=App\Models\Student::where('user_id',Auth::user()->id)->whereNotNull('course_id')->count();
$uncompletePro=App\Models\Profile::where('user_id',Auth::user()->id)->count();

$completionPercentage = 0;
if ($completePro > 0) {
$completionPercentage = 100;
} elseif ($uncompletePro > 0) {
$completionPercentage = 50;
} else {
$completionPercentage = 30;
}

@endphp
@include('studentFrontend.layouts.profile-details-common-tab')
@yield('content')

@include('studentFrontend.layouts.footer')