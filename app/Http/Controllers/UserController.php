<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\Course;
use App\Models\Profile;
use App\Models\State;
use App\Models\Student;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
       
       $roles=Role::all();
       
        return view('user_register',compact('roles'));
    }
    public function store(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'phone' => 'required|max:10|min:10',
            'address' => 'required',
            'role' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
     
        try {
            
        $password = Hash::make($request->password);
        
        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'address'=>$request->address,
            'password'=>$password ,
        ]);
        $user->assignRole($request->role);
            
        return response()->json(['success' => true, 'message' => 'User Added/Updated successfully']);

        
        }catch(Exception $e){
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
        
        
    }

    public function user_list(Request $request){
        $users=User::leftJoin('model_has_roles','users.id','=','model_has_roles.model_id')->leftJoin('roles','model_has_roles.role_id','=','roles.id')->select('users.*','roles.name as role_name',)->get();
        
        return view('admin.userList',compact('users'));
    }
    public function edit($id)
    {
        
        $user=user::leftJoin('profiles','users.id','=','profiles.user_id')->leftJoin('students','users.id','=','students.user_id')->where('users.id' ,$id)->select('users.id as id1','users.*','profiles.*','students.*')->first();
        $role_name=DB::table('model_has_roles')->leftJoin('roles','model_has_roles.role_id','=','roles.id')->where('model_has_roles.model_id',$id)->select('roles.name as role_name',)->first();
        
        $courses=Course::pluck('id','course_name');
        $countrys=Country::pluck('id','country_name');
      
         return view('admin.user_edit',compact('user','countrys','courses','role_name'));
    
    }
    public function destroy(Request $request)
    {
        
        $user = User::find($request->id);
    
        if ($user) {
            $user->delete();
            Profile::where('user_id',$request->id)->delete();
            Student::where('user_id',$request->id)->delete();
            
            return response()->json(['success' => true, 'message' => 'User deleted successfully']);
           
        } else {
            return response()->json(['error' => true, 'message' => 'User not deleted.... ']);
        }
    
       
    }

    public function student_list(Request $request){
       
        if(Student::count()>0){
            $users=Student::leftJoin('users','students.user_id','=','users.id')->leftJoin('profiles','users.id','=','profiles.user_id')->select('users.id as id1','users.*','profiles.*','students.*')->get();

        }else{
            $users=null;
        }
        return view('admin.student',compact('users'));
    }

    public function my_transaction(Request $request){
        $user_id=Auth::user()->id ;
        $student_id = Student::where('user_id',$user_id)->first();
        $courses=Course::where('id',$student_id->course_id)->value('course_name');
        $my_transactions=DB::table('transaction')->where('student_id',$student_id->id)->get();
        return view('payment.my_transaction',compact('my_transactions','courses'));
    }

    public function notification_list(){
        return view('student.notifications');
    }
}
