@extends('layouts.student_master')
@section('content')
    
            <div class="row justify-content-center mt-4">
                <div class="col-lg-9">
                   
                    <!-- Change Password -->
                    <div class="accordion" id="editProfile">
                        <div class="accordion-item box border-0 mb-3 rounded-2">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Change Password
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                                data-bs-parent="#dasboardAccordion1">
                                <div class="accordion-body profile-info">
                                    <form action="{{ route('update-password') }}" method="POST">
                                        @csrf
                                    <div class="row">
                                        <div class="col-lg-12 mb-3">
                                            <div class="form-floating pass_word">
                                                <input type="password" name="old_password" class="form-control" id="floatingInput"
                                                    placeholder="Enter Code">
                                                <i class="fas fa-eye-slash toggle-password"></i>
                                                <label for="floatingInput">Old Password</label>
                                            </div>
                                            @error('old_password')
                                            <span class="text-danger">{{ $message }}</span>
                                             @enderror
                                        </div>
                                        <div class="col-lg-12 mb-3">
                                            <div class="form-floating pass_word">
                                                <input type="password" class="form-control" name="new_password" id="floatingInput"
                                                    placeholder="Enter Code">
                                                <i class="fas fa-eye-slash toggle-password"></i>
                                                <label for="floatingInput">New Password</label>
                                            </div>
                                            @error('new_password')
                                            <span class="text-danger">{{ $message }}</span>
                                             @enderror
                                        </div>
                                        <div class="col-lg-12 mb-3">
                                            <div class="form-floating pass_word">
                                                <input type="password" name="new_password_confirmation" class="form-control" id="floatingInput"
                                                    placeholder="Enter Code">
                                                <i class="fas fa-eye-slash toggle-password"></i>
                                                <label for="floatingInput">Confirm Password</label>
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
                    </div>

                </div>
            </div>
        </div>
    </section>
    
    <script>
        $(document).ready(function () {
            $(".toggle-password").click(function () {
                $(this).toggleClass("fa-eye fa-eye-slash");
                input = $(this).parent().find("input");
                if (input.attr("type") == "password") {
                    input.attr("type", "text");
                } else {
                    input.attr("type", "password");
                }
            });
        });


    </script>
 @endsection