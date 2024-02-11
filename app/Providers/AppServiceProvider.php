<?php

namespace App\Providers;

use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer('*', function ($view) {
            $student_profile = Student::where('user_id', Auth::user()->id)
                ->leftJoin('grades', 'students.class_id', '=', 'grades.id')
                ->leftJoin('courses', 'students.course_id', '=', 'courses.id')
                ->select('grades.class_name as class_name', 'courses.course_name as course_name', 'courses.duration as duration', 'students.*')
                ->first();

            $view->with('student_profile', $student_profile);
        });
    }
}
