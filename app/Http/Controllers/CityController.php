<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $countrys=Country::pluck('id','country_name');
        $states=State::leftJoin('countries','countries.id','=','states.country_id')->select('states.id as state_id','countries.country_name','states.state_name','states.is_active')->get();
       $citys=City::leftJoin('states','states.id','=','cities.state_id')->leftJoin('countries','countries.id','=','states.country_id')->select('cities.id as city_id','cities.city_name as city_name','countries.country_name','states.state_name','cities.is_active')->get();
        return view('admin.city',compact('countrys','states','citys'));
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
            'city_name' => 'required|string|max:255',
            'country_id' => 'required',
            'state_id' => 'required',
        ],
        [
            'city_name.required' => 'City Field is required',
            'country_id.required' => 'Country Field is required',
            'state_id.required' => 'State Field is required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $data=$request->all();
      
        $data['is_active']=0;
        try {
            if($data['id']==null){
                City::create($data);
            }else{
                City::findOrFail($data['id'])->update($data);
            }
            return response()->json(['success' => true, 'message' => 'City Added/Updated successfully']);

           
        }catch(Exception $e){
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $id=$request->id;
        $city=City::findOrFail($id);
        $state_name=State::where('id',$city->state_id)->first();
       
        return response()->json(['city' => $city,'state'=>$state_name->state_name]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, City $city)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        
        $city = City::find($request->id);
    
        if ($city) {
            $city->delete();
            return response()->json(['success' => true, 'message' => 'City deleted successfully']);
           
        } else {
            return response()->json(['error' => true, 'message' => 'City not deleted.... ']);
        }
    
       
    }
    public function countryWiseState(Request $request){
       
        if($request->country_id){
            $countryId=$request->country_id;
            $state=State::where('country_id',$countryId)->pluck('state_name','id');
            
            return response()->json($state);
        }
        
       
    }
}
