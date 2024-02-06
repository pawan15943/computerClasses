<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $grades=Grade::get();
        return view('admin.class' , compact('grades'));
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
       
        $validator = Validator::make($request->all(), [
            'class_name' => 'required|string|max:100',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $data=$request->all();
       
        $data['is_active']=0;
        try {
            if($data['id']==null){
                Grade::create($data);
            }else{
                Grade::findOrFail($data['id'])->update($data);
            }
            return response()->json(['success' => true, 'message' => 'Class Added/Updated successfully']);

           
        }catch(Exception $e){
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Grade $grade)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $id=$request->id;
        $grade=Grade::findOrFail($id);
       
       
        return response()->json(['grade' => $grade]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Grade $grade)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        
        $course = Grade::find($request->id);
    
        if ($course) {
            $course->delete();
            return response()->json(['success' => true, 'message' => 'Class deleted successfully']);
           
        } else {
            return response()->json(['error' => true, 'message' => 'Class not deleted.... ']);
        }
    
    }
}
