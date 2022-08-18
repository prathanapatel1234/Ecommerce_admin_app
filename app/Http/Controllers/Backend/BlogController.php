<?php

namespace App\Http\Controllers\Backend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use App\Blog;
use DB;
use Hash;
use DataTables;
use Validator;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $blog=array();
        $blog = Blog::get();
        return view('admin.blog.blog')->with(['blog'=>$blog]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$blog = Blog::get();
        return view('admin.blog.blog-create',compact('blog'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:blog,title',
            'image' => 'nullable|mimes:jpg,png,jpeg',
            'slug'=>'required'
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }



        $blog = new Blog();
        $blog->title = $request->title;
        $blog->description = $request->description;
        $blog->slug = $request->slug;
        $blog->status = $request->status;
        $image = "";
        if($request->hasFile('image'))
        {
        $image = 'blog_'.time().'.'.$request->image->extension();
        $request->image->move(public_path('/uploads/blog'), $image);
        $image = "/uploads/blog/".$image;
        }
        $blog->image = $image ;
        $blog->save();


        return response()->json([
            'status' => true,
            'msg' => 'Blog created successfully'
			]);

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $loan = Blog::with('parent_detail')->find($id);
        return view('admin.blog.blog-show',compact('loan'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Blog::find($id);
        return view('admin.blog.blog-edit')->with(['post'=>$post]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), ['title' => 'required']);
        if ($validator->fails()) return response()->json(['status' => false,'errors' => $validator->errors()]);
        $image = "";
        if($request->hasFile('image'))
        {
        $image = 'blog_'.time().'.'.$request->image->extension();
        $request->image->move(public_path('/uploads/blog'), $image);
        $image = "/uploads/blog/".$image;
        }
        else $image=$request->old_image;
        $blog = Blog::find($id);
        $blog->title = $request->title;
        $blog->slug = $request->slug;
        $blog->description = $request->description;
        $blog->status = $request->status;
        $blog->image = $image ;
        $blog->save();
        return response()->json(['status' => true,'msg' => 'Blog updated successfully']);

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Blog::find($id)->delete();
    }



}
