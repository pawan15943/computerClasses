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
                {{-- <nav aria-label="...">
                    <ul class="pagination pagination-sm">
                        <li class="page-item active" aria-current="page">
                            <span class="page-link">1</span>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                    </ul>
                </nav> --}}
            </div>
        </div>
    </div>
</section>
@endsection