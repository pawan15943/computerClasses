@extends('layouts.student_master')
@section('content')
        <div class="row mt-4 justify-content-center">
            <div class="col-lg-9">
                @foreach(auth()->user()->notifications as $notification)
                <div class="card box border-0 mb-3" data-aos="fade-up" data-aos-duration="400">
                    <div class="card-body">
                        <h4 class="card-title mb-2"><i class="fa fa-bell me-2"></i>{{ $notification['data']['tital'] }}</h4>
                        <p class="card-text m-0  mb-2 text-secondary">{{ $notification['data']['message'] }}</p>
                        <a href="{{ $notification['data']['url'] }}" class="card-link">Click Here <i class="las la-angle-right"></i></a>
                    </div>
                </div>
                @endforeach
               
            </div>
        </div>
    </div>
</section>
@endsection