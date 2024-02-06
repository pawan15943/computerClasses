<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Profile;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Contracts\Role;
use Spatie\Permission\Traits\HasRoles;
use Auth;
use App\Notifications\CustomNotification;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $total_student = User::leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')->leftJoin('roles', 'model_has_roles.role_id', '=', 'roles.id')->where('roles.name', 'Student')->count();

        $paid_student = Student::where('is_paid', 1)->count();
        $count_student = Student::count();
        $pending_student = Student::whereNull('course_id')->count();
        $total_amount = Student::sum('paid_amount');
        $courseCounts = Student::join('courses', 'students.course_id', '=', 'courses.id')
            ->selectRaw('students.course_id, courses.course_name, COUNT(*) as total_students')
            ->groupBy('students.course_id', 'courses.course_name')
            ->get();


        if (Auth::user()->hasRole('Student') == true) {
            $completePro = Student::where('user_id', Auth::user()->id)->whereNotNull('course_id')->count();
            if (Profile::where('user_id', Auth::user()->id)->count() > 0 && $completePro > 0) {
                $user_profile = Profile::where('profiles.user_id', Auth::user()->id)->leftJoin('countries', 'profiles.country_id', '=', 'countries.id')->leftJoin('states', 'profiles.state_id', '=', 'states.id')->leftJoin('cities', 'profiles.city_id', '=', 'cities.id')->select('cities.city_name as city_name', 'states.state_name as state_name', 'countries.country_name as country_name', 'profiles.*')->first();
                $student_profile = Student::where('user_id', Auth::user()->id)->leftJoin('grades', 'students.class_id', '=', 'grades.id')->leftJoin('courses', 'students.course_id', '=', 'courses.id')->select('grades.class_name as class_name', 'courses.course_name as course_name', 'courses.duration as duration', 'students.*')->first();

                return view('student.student_dashboard', compact('user_profile', 'student_profile'));
            } else {
                return redirect('/profile')->with('message', 'You have successfully registerd');
            }
        } elseif (Auth::user()->hasRole('admin') == true) {
            return view('home', compact('total_student', 'paid_student', 'pending_student', 'count_student', 'total_amount', 'courseCounts'));
        } else {
            if (Profile::where('user_id', Auth::user()->id)->count() > 0) {
                return view('home', compact('total_student', 'paid_student'));
            } else {
                return redirect('/profile')->with('message', 'You have successfully registerd');
            }
        }
    }
}
