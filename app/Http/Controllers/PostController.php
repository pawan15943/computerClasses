<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Exception;
use Illuminate\Http\Request;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    use HasRoles;
    

    public function __construct()
    {
        $this->middleware(['role:admin']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $posts=Post::get();
        return view('admin.post',compact('posts'));
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
            'post_title' => 'required|string',
            'post_image' => 'required|mimes:png,jpg,jpeg|max:5120',
            'post_alt_value' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        
      
       if($request->hasFile('post_image'))
       {
           $this->validate($request,['post_image' => 'mimes:pdf,doc,docx,png,jpg,jpeg|max:5120']);
           $post_image = $request->post_image;
           $post_imageNewName = "post_image".time().$post_image->getClientOriginalName();
           $post_image->move('public/uploads/',$post_imageNewName);
           $post_image = 'public/uploads/'.$post_imageNewName;
       }
      

        $data=$request->all();
        $data['is_active']=0;
       $data['post_image']=$post_image;
        try {
            if($data['id']==null){
                Post::create($data);
            }else{
                Post::findOrFail($data['id'])->update($data);
            }
            return response()->json(['success' => true, 'message' => 'Post Added/Updated successfully']);

           
        }catch(Exception $e){
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $id=$request->id;
        $post=Post::findOrFail($id);
        return response()->json(['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        
        $course = Post::find($request->id);
    
        if ($course) {
            $course->delete();
            return response()->json(['success' => true, 'message' => 'Post deleted successfully']);
           
        } else {
            return response()->json(['error' => true, 'message' => 'Post not deleted.... ']);
        }
    
    }
}
