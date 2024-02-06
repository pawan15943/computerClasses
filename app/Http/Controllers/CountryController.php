<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function index(){
      $countrys=Country::get();
        return view('admin.country',compact('countrys'));
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
        $data=$request->all();
        $validator = Validator::make($request->all(), [
            'country_name' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
       
        $data['is_active']=0;
        try {
            if($data['id']==null){
                Country::create($data);

            }else{
                Country::findOrFail($data['id'])->update($data);
            }
            return response()->json(['success' => true, 'message' => 'Country Added/Updated successfully']);

           
        }catch(Exception $e){
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Country $country)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $id=$request->id;
        $country=Country::findOrFail($id);
      
        return response()->json(['country' => $country]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Country $country)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        
        $country = Country::find($request->id);
    
        if ($country) {
            $country->delete();
            return response()->json(['success' => true, 'message' => 'Country deleted successfully']);
           
        } else {
            return response()->json(['error' => true, 'message' => 'Country not deleted.... ']);
        }
    
    }
}
