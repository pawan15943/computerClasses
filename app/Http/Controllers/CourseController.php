<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses=Course::get();
        return view('admin.course',compact('courses'));
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
        // dd($request);
        $validator = Validator::make($request->all(), [
            'course_name' => 'required|string|max:255',
            'course_code' => 'required',
            'course_fees' => 'required',
            'duration' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'syllabus' => 'required|mimes:png,jpg,jpeg,pdf|max:5120',
            'shedule' => 'required|mimes:png,jpg,jpeg,pdf|max:5120',
        ],
        [
            'course_name.required' => 'Course Field is required',
            'course_code.required' => 'Course Code is required',
            'course_fees.required' => 'Course Fees is required',     
            'duration.required' => 'Course Duration is required',
            'start_date.required' => 'Start Date Field is required',
            'end_date.required' => 'End Date Field is required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        $data=$request->all();

        if($request->hasFile('syllabus'))
        {
            $this->validate($request,['syllabus' => 'mimes:pdf,doc,docx,png,jpg,jpeg,pdf|max:5120']);
            $syllabus = $request->syllabus;
            $syllabusNewName = "syllabus".time().$syllabus->getClientOriginalName();
            $syllabus->move('public/uploads/',$syllabusNewName);
            $syllabus = 'public/uploads/'.$syllabusNewName;
        }
 
        $data['syllabus']=$syllabus;
        
        if($request->hasFile('shedule'))
        {
            $this->validate($request,['shedule' => 'mimes:pdf,doc,docx,png,jpg,jpeg,pdf|max:5120']);
            $shedule = $request->shedule;
            $sheduleNewName = "shedule".time().$shedule->getClientOriginalName();
            $shedule->move('public/uploads/',$sheduleNewName);
            $shedule = 'public/uploads/'.$sheduleNewName;
        }
 
        $data['shedule']=$shedule;
        $data['is_active']=0;
        $discount=$data['discount'];
        $course_fees=$data['course_fees'];

        $installment_1=$course_fees*(50/100) ;
        $installment_2=$course_fees*(30/100) ;
       
        if($discount==null){
            $lumpsum=$course_fees*(90/100) ;
            
        }else{
            $lumpsum=$course_fees*(80/100) ;
           
        }
        if($discount==null){
            $installment_3=$course_fees*(20/100) ;
        }elseif($discount<=20){
            $installment_3=($course_fees*(20/100))-($course_fees*($discount/100)) ;
        }else{
            $installment_3=0;
        }
        
        $data['installment_1']=$installment_1;
        $data['installment_2']=$installment_2;
        $data['installment_3']=$installment_3;
        $data['lumpsum']=$lumpsum;
        try {
            if($data['id']==null){
                Course::create($data);
            }else{
                Course::findOrFail($data['id'])->update($data);
            }
            return response()->json(['success' => true, 'message' => 'Course Added/Updated successfully']);

           
        }catch(Exception $e){
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $id=$request->id;
        $course=Course::findOrFail($id);
       
       
        return response()->json(['course' => $course]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        
        $course = Course::find($request->id);
    
        if ($course) {
            $course->delete();
            return response()->json(['success' => true, 'message' => 'Course deleted successfully']);
           
        } else {
            return response()->json(['error' => true, 'message' => 'Course not deleted.... ']);
        }
    
    }
}
