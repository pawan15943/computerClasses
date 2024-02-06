<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\Course;
use App\Models\Grade;
use App\Models\Profile;
use App\Models\State;
use App\Models\Student;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses=Course::pluck('id','course_name');
        $countrys=Country::pluck('id','country_name');
        $classes=Grade::pluck('id','class_name');
        $user_profile=Profile::where('user_id',Auth::user()->id)->first();
        if(Profile::where('user_id',Auth::user()->id)->count()>0){
            
            $selectedState=State::where('country_id', $user_profile->country_id)->pluck('id','state_name');
            $selectedcity=City::where('state_id',$user_profile->state_id)->pluck('id','city_name');
            if(Auth::user()->hasRole('Student')==true){
                return view('student.student_profile',compact('classes','countrys','courses','user_profile','selectedState','selectedcity'));
            }else{
                return view('profile',compact('classes','countrys','courses','user_profile','selectedState','selectedcity'));

            }
        }else{
            if(Auth::user()->hasRole('Student')==true){
                return view('student.student_profile' ,compact('classes','countrys','courses','user_profile'));
            }else{
                return view('profile',compact('classes','countrys','courses','user_profile'));

            }
        }
      
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    { 
   
        if($request->myForm_id){
            $validator = Validator::make($request->all(), [
                'name' => ['required_if:myForm_id,==,myForm_id'],
                 'user_id' => 'required',
                 'dob' =>['required_if:myForm_id,==,myForm_id'],
                 'email' =>['required_if:myForm_id,==,myForm_id'],
                 'phone' => ['required_if:myForm_id,==,myForm_id'],
                 'gender' => ['required_if:myForm_id,==,myForm_id'],
                 'father_name' => ['required_if:myForm_id,==,myForm_id'],
                 'address_line_1' => ['required_if:myForm_id,==,myForm1'],
                 'address_line_2' => ['required_if:myForm_id,==,myForm1'],
                 'pincode' => ['required_if:myForm_id,==,myForm1'],
                 'country_id' => ['required_if:myForm_id,==,myForm1'],
                 'state_id' => ['required_if:myForm_id,==,myForm1'],
                 'city_id' => ['required_if:myForm_id,==,myForm1'],
                 'suggestion_method' => ['required_if:myForm_id,==,myForm2'],
                 'class_id' => ['required_if:myForm_id,==,myForm3'],
                 'course_id' => ['required_if:myForm_id,==,myForm3'],
                 'center' => ['required_if:myForm_id,==,myForm3'],
                 'user_photo' => ['required_if:myForm_id,==,myForm4'],
              
            ],
            [
                'name.required_if' => 'Name is required',
                'dob.required_if' => 'DOB is required',
                'phone.required_if' => 'Phone No. is required',
                'father_name.required_if' => 'Father Name is required',
                'user_photo.required_if' => 'Photo is required',
                'country_id.required_if' => 'Country Field is required',
                'state_id.required_if' => 'State Field is required',
                'city_id.required_if' => 'City Field is required',
                'class_id.required_if' => 'Class Field is required',
                'course_id.required_if' => 'Course Field is required',
                'gender.required_if' => 'Gender Field is required',
                'address_line_1.required_if' => 'Address Line 1 Field is required',
                'address_line_2.required_if' => 'Address Line 2 Field is required',
                'pincode.required_if' => 'Pincode Field is required',
                'suggestion_method.required_if' => 'Suggestion method Field is required',
                'center.required_if' => 'Center Field is required',
                
            ]);
        }else{
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                 'user_id' => 'required',
                 'dob' =>'required',
                 'email' =>'required',
                 'phone' => 'required',
                 'gender' => 'required',
                 'father_name' => 'required',
                 'address' => 'required',
                 'country_id' => 'required',
                 'state_id' => 'required',
                 'city_id' => 'required',     
                 'user_photo' => 'required',
              
            ],
           );
        }
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        $user_id=$request->user_id ;
        if($request->myForm_id=='myForm3'){
          
            $profile=Profile::where('user_id', $user_id)->count();
            $profile_null = Profile::where('user_id', '=', $user_id)
            ->where(function ($query) {
                $query->whereNull('dob')
                      ->orWhereNull('gender')
                      ->orWhereNull('father_name')
                      ->orWhereNull('country_id')
                      ->orWhereNull('suggestion_method');
            })
            ->count();
            
            if($profile_null>0 || $profile<1){
                return response()->json(['profile_errors' => true, 'message' => 'Please update profile']);
            }
            
        }
       
        if($request->address){
            $address=$request->address;
        }
        
        if($request->address_line_1 && $request->address_line_2 && $request->pincode){
            $address=$request->address_line_1.','.$request->address_line_2.'-'.$request->pincode;
        }
        try {
          
            if($user_id){
                    $profile=Profile::where('user_id', $user_id)->count();
                    $student=Student::where('user_id',$user_id)->count();
            
                    if($request->hasFile('user_photo')){
                    
                        $this->validate($request,['user_photo' => 'mimes:png,jpg,jpeg|max:5120']);
                        $user_photo = $request->user_photo;
                        $user_photoNewName = "user_photo".time().$user_photo->getClientOriginalName();
                        $user_photo->move('public/uploads/',$user_photoNewName);
                        $user_photo = 'public/uploads/'.$user_photoNewName;
                        
                    }else{
                        $user=User::findOrFail($user_id);
                        $user_photo=$user->user_photo;
                    }
              
                if($profile>0 ){
                    if($request->myForm_id=='myForm_id'){
                        Profile::where('user_id', $user_id)->update([
                            'dob'=>$request->dob,
                            'gender'=>$request->gender,
                            'father_name'=>$request->father_name
                        ]);
                        User::findOrFail($user_id)->update([
                            'name'=>$request->name,
                            'phone'=>$request->phone,
                        ]);
                    }elseif($request->myForm_id=='myForm1'){
                        Profile::where('user_id', $user_id)->update([ 
                            'country_id'=>$request->country_id,
                            'state_id'=>$request->state_id,
                            'city_id'=>$request->city_id,
                        ]);
                        User::findOrFail($user_id)->update([
                            
                            'address'=>$address,  
                        ]);
                    }elseif($request->myForm_id=='myForm2'){
                        Profile::where('user_id', $user_id)->update([
                            'suggestion_method'=>$request->suggestion_method,
                            'suggested_person_name'=>$request->suggested_person_name,
                        ]);
                    }elseif($request->myForm_id=='myForm3'){
                       
                        $student_pro=Profile::where('user_id', $user_id)->whereNotNull('country_id')->whereNotNull('state_id')->whereNotNull('city_id')->whereNotNull('dob')->whereNotNull('gender')->count();
                        
                        if(Auth::user()->hasRole('Student')==true && $student_pro >0){
                            
                            $count=Student::where('user_id',$user_id)->count();
                            
                            if($count>0){
                                Student::where('user_id',$user_id)->update([
                                    'class_id'=>$request->class_id,
                                    'course_id'=>$request->course_id,  
                                    'center'=>$request->center,
                                ]);
                            }else{

                                Student::create([
                                    'class_id'=>$request->class_id,
                                    'course_id'=>$request->course_id,  
                                    'user_id'=> $user_id,
                                    'center'=>$request->center,
                                ]);
                                
                            }
                           
                        }else{
                            return response()->json(['success' => false, 'message' => 'Update Profile']);
                        }
                    }elseif($request->myForm_id=='myForm4'){
                        User::findOrFail($user_id)->update([
                          
                            'user_photo'=>$user_photo,
                        ]);
                    }else{
                        Profile::where('user_id', $user_id)->update([
                            'dob'=>$request->dob,
                            'gender'=>$request->gender,
                            'country_id'=>$request->country_id,
                            'state_id'=>$request->state_id,
                            'city_id'=>$request->city_id,
                            'father_name'=>$request->father_name,
                        ]);
                        User::findOrFail($user_id)->update([
                            'name'=>$request->name,
                            'phone'=>$request->phone,
                            'address'=>$address,
                            'user_photo'=>$user_photo,
                        ]);
                    }
                  
                }else{
                  
                    if($request->myForm_id=='myForm_id'){
                       
                        Profile::create([
                            'dob'=>$request->dob,
                            'gender'=>$request->gender,
                            'user_id'=> $user_id,
                            'father_name'=>$request->father_name
                            ]);
                        User::findOrFail($user_id)->update([
                            'name'=>$request->name,
                            'phone'=>$request->phone,
                        ]);
                    }elseif($request->myForm_id=='myForm1'){
                       
                        Profile::create([
                            'country_id'=>$request->country_id,
                            'state_id'=>$request->state_id,
                            'city_id'=>$request->city_id,
                            'user_id'=> $user_id,
                            ]);
                        User::findOrFail($user_id)->update([
                            
                            'address'=>$address,
                           
                        ]);
                    }elseif($request->myForm_id=='myForm2'){
                        Profile::create([
                            'suggestion_method'=>$request->suggestion_method,
                            'suggested_person_name'=>$request->suggested_person_name,
                            'user_id'=> $user_id,
                            ]);
                    }elseif($request->myForm_id=='myForm3'){

                        if(Auth::user()->hasRole('Student')==true){
                            $count=Student::where('user_id',$user_id)->count();
                            if($count>0){

                                Student::where('user_id',$user_id)->update([
                                    'class_id'=>$request->class_id,
                                    'course_id'=>$request->course_id,  
                                    'center'=>$request->center,
                                ]);
                            }else{

                                Student::create([
                                    'class_id'=>$request->class_id,
                                    'course_id'=>$request->course_id,  
                                    'user_id'=> $user_id,
                                    'center'=>$request->center,
                                ]);
                            }
                           
                        }
                    }elseif($request->myForm_id=='myForm4'){
                        User::findOrFail($user_id)->update([
                          
                            'user_photo'=>$user_photo,
                        ]);
                    }else{
                        Profile::create([
                            'dob'=>$request->dob,
                            'gender'=>$request->gender,
                            'country_id'=>$request->country_id,
                            'state_id'=>$request->state_id,
                            'city_id'=>$request->city_id,
                            'user_id'=> $user_id,
                            ]);
                        User::findOrFail($user_id)->update([
                            'name'=>$request->name,
                            'phone'=>$request->phone,
                            'address'=>$address,
                            'user_photo'=>$user_photo,
                        ]);
                    }   
                }
               

                if(Auth::user()->hasRole('Student')==true){
                    $student_role=1;
                }else{
                    $student_role=0;
                }
               
            }

            return response()->json(['success' => true, 'message' => 'Profile Updated successfully' ,'student' =>$student_role]);

        }catch(Exception $e){
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Profile $profile)
    {
        $user_profile=Profile::where('profiles.user_id',Auth::user()->id)->leftJoin('countries','profiles.country_id','=','countries.id')->leftJoin('states','profiles.state_id','=','states.id')->leftJoin('cities','profiles.city_id','=','cities.id')->select('cities.city_name as city_name','states.state_name as state_name','countries.country_name as country_name','profiles.*')->first();
                
        $student_profile=Student::where('user_id',Auth::user()->id)->leftJoin('grades','students.class_id','=','grades.id')->leftJoin('courses','students.course_id','=','courses.id')->select('grades.class_name as class_name','courses.course_name as course_name','courses.duration as duration','students.*')->first();
       
        return view('student.student_profile_view',compact('user_profile','student_profile'));


    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Profile $profile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Profile $profile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile)
    {
        //
    }

    public function stateWiseCity(Request $request){
       
        if($request->state_id){
            $stateId=$request->state_id;
            $city=City::where('state_id',$stateId)->pluck('city_name','id');
           
            return response()->json($city);
        }
        
       
    }

    public function changePassword(){
        return view('auth.passwords.change-password');
    }
    public function updatePassword(Request $request)
    {
        # Validation
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);


        #Match The Old Password
        if(!Hash::check($request->old_password, auth()->user()->password)){
            return back()->with("error", "Old Password Doesn't match!");
        }


        #Update the new Password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with("status", "Password changed successfully!");
    }


}
