<?php

namespace App\Providers;

use App\Models\Profile;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use DB;

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
            $student_profile = null;
            $transections = null;
            $lastTransaction = null;
            $transection_count = 0;
            $completionPercentage = 0;
    
            if (Auth::check()) {
                $student_profile = Student::where('user_id', Auth::user()->id)
                    ->leftJoin('grades', 'students.class_id', '=', 'grades.id')
                    ->leftJoin('courses', 'students.course_id', '=', 'courses.id')
                    ->select('grades.class_name as class_name', 'courses.course_name as course_name', 'courses.duration as duration', 'students.*')
                    ->first();
    
                $completePro = Student::where('user_id', Auth::user()->id)->whereNotNull('course_id')->count();
                $uncompletePro = Profile::where('user_id', Auth::user()->id)->count();
                //We get Profile Completion Percenttage
                if ($completePro > 0 && $uncompletePro > 0) {
                    $completionPercentage = 100;
                } elseif ($uncompletePro > 0) {
                    $completionPercentage = 50;
                } else {
                    $completionPercentage = 30;
                }

                $student =Student::where('user_id', Auth::user()->id)->first();
                if($student != null){
                $transections = DB::table('transaction')->where('student_id', $student->id)->get();
                $transection_count = $transections->count();
                $lastTransaction = $transections->last();
                }else{
                    $transections=null;
                }
            }
    
            $view->with('student_profile', $student_profile)
                 ->with('completionPercentage', $completionPercentage)
                 ->with('transections', $transections)
                 ->with('lastTransaction', $lastTransaction)
                 ->with('transection_count', $transection_count);
        });
    }
    
}
