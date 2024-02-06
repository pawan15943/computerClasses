
@php
$completePro=App\Models\Student::where('user_id',Auth::user()->id)->whereNotNull('course_id')->count();
$studdent=App\Models\Student::join('courses','courses.id','=','students.course_id')->where('user_id',Auth::user()->id)->first();
@endphp

@if($uncompletePro > 0)
<div id="data">
    <ul class="menus">
        <li>
            @if($completionPercentage==100)
            <a href="{{ route('home') }}"> <i class="fa fa-dashboard"></i> Dashboard</a>
            @else
            <a> <i class="fa fa-dashboard"></i> Dashboard</a>
            @endif
        </li>

        <li>
            @if($studdent && $studdent->shedule)
            <a href="{{ $studdent->shedule }}"><i class="fa fa-book"></i> My Scheduled</a>
            @else
            <a href="#"><i class="fa fa-book"></i> My Scheduled</a>
            @endif

        </li>

        <li>
            @if($studdent && $studdent->syllabus)
            <a href="{{$studdent->syllabus}}"><i class="fa fa-file"></i> Download Syllabus</a>
            @else
            <a href=""><i class="fa fa-file"></i> Download Syllabus</a>
            @endif
        </li>

        <li>
            <a href=""><i class="fa fa-certificate"></i> Download Certificate</a>
        </li>

        <li>
            @if($completionPercentage==100)
            <a href="{{route('profile.show')}}"><i class="fa fa-user-circle"></i> My Profile</a>
            @else
            <a><i class="fa fa-user-circle"></i> My Profile</a>
            @endif
        </li>

        <li>
            <a href="{{route('change-password')}}"><i class="fa fa-user-circle"></i> Change Password</a>
        </li>

        <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i>
                Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </li>

    </ul>
</div>

<div class="plus-icon" id="plus">
    <i class="fa fa-plus"></i>
</div>
@endif


<footer class="bg-black">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center p-2 text-white">Copyrights <?php echo date('Y') ?> New Balaji Computer Classes. All rights reserved.
            </div>
        </div>
    </div>
</footer>
<!-- Page Content Ends Here -->

<!-- JQuery file -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap file-->

<!-- Owl Js file -->
<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/js/owl-functions.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.7/dist/sweetalert2.all.min.js"></script>
<!-- Bootstrap file-->
<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>

<script>
    $('#plus').on('click', function() {
        $('#data').toggleClass('show');
        $('#plus .fa').toggleClass('rotate');
    });
</script>

<script>
    $(document).ready(function() {
        $(".content").mCustomScrollbar({
            axis: "y",
            theme: "dark",
            setLeft: 0,
            scrollbarPosition: "inside",
            mouseWheel: {
                enable: true
            },
        });
    });
</script>
</body>

</html>