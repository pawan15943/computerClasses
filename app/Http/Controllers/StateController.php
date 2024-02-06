<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\State;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $countrys=Country::pluck('id','country_name');
        $states=State::leftJoin('countries','countries.id','=','states.country_id')->select('states.id as state_id','countries.country_name','states.state_name','states.is_active')->get();
       
        return view('admin.state',compact('countrys','states'));
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
            'state_name' => 'required|string|max:255',
            'country_id' => 'required',
        ],
        [
            'country_id.required' => 'Country Field is required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        $data=$request->all();
       
        $data['is_active']=0;
        try {
            if($data['id']==null){
                State::create($data);
            }else{
                State::findOrFail($data['id'])->update($data);
            }
            
            return response()->json(['success' => true, 'message' => 'State Added/Updated successfully']);
        }catch(Exception $e){
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(State $state)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        // dd($request);
        $id=$request->id;
        $state=State::findOrFail($id);
        return response()->json(['state' => $state]);
        // return $state ;
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, State $state)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(State $state)
    // {
    //     //
    // }

    public function destroy($id)
    {
        State::find($id)->delete();
  
        return redirect()->back();
    }

    
}
