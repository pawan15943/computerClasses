<?php

namespace App\Http\Controllers;

use App\Models\StudentAsset;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentAssetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $student_assets=StudentAsset::get();
        return view('admin.student_asset',compact('student_assets'));
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
            'asset_name' => 'required|string',
            'asset_file' => 'required|mimes:png,jpg,jpeg|max:5120',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
       $data=$request->all();
       $data['is_active']=0;
       if($request->hasFile('asset_file'))
       {
           $this->validate($request,['asset_file' => 'mimes:pdf,doc,docx,png,jpg,jpeg|max:5120']);
           $asset_file = $request->asset_file;
           $asset_fileNewName = "asset_file".time().$asset_file->getClientOriginalName();
           $asset_file->move('public/uploads/',$asset_fileNewName);
           $asset_file = 'public/uploads/'.$asset_fileNewName;
       }

       $data['asset_file']=$asset_file;
        try {
            if($data['id']==null){
                StudentAsset::create($data);
            }else{
                StudentAsset::findOrFail($data['id'])->update($data);
            }
            return response()->json(['success' => true, 'message' => 'Assets Added/Updated successfully']);

           
        }catch(Exception $e){
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(StudentAsset $studentAsset)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $id=$request->id;
        $assets=StudentAsset::findOrFail($id);
       
       
        return response()->json(['assets' => $assets]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StudentAsset $studentAsset)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        
        $course = StudentAsset::find($request->id);
    
        if ($course) {
            $course->delete();
            return response()->json(['success' => true, 'message' => 'Assets deleted successfully']);
           
        } else {
            return response()->json(['error' => true, 'message' => 'Assets not deleted.... ']);
        }
    
    }
}
