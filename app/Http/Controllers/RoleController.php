<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Exception;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $roles = Role::orderBy('id','DESC')->paginate(5);
        $permission = Permission::get();
        // return view('admin.role',compact('permission'))->with('i', ($request->input('page', 1) - 1) * 5);
        return view('admin.role',compact('permission','roles'));
    }

    public function store(Request $request)
    {
       
        DB::beginTransaction();
        // dd($request);
        $id=$request->id;
        try {
            $permissionNames = Permission::whereIn('id', $request->permission)->pluck('name')->toArray();
            if($id==null){
               
                $role = Role::create(['name' => $request->name]);
                $role->syncPermissions($permissionNames);
            }else{
                // City::findOrFail($data['id'])->update($data);
                $role = Role::find($id);
                $role->name = $request->name;
                $role->save();
                $role->syncPermissions($permissionNames);
            }
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Role Added/Updated successfully']);

           
        }catch(Exception $e){
            DB::rollback();

            // Log the error
            Log::error($e->getMessage());
        
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function edit(Request $request)
    {
        $id=$request->id;
        $role=Role::findOrFail($id);
       
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
        return response()->json(['role' => $role,'rolePermissions'=>$rolePermissions]);
    }

    public function destroy(Request $request)
    {
        
        $role = Role::find($request->id);
    
        if ($role) {
            $role->delete();
            $permissions=DB::table("role_has_permissions")->where("role_has_permissions.role_id",$role->id)->delete();
            return response()->json(['success' => true, 'message' => 'City deleted successfully']);
           
        } else {
            return response()->json(['error' => true, 'message' => 'City not deleted.... ']);
        }
    
        // return redirect()->back();
    }
}
