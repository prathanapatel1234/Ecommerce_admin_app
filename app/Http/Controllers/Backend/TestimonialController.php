<?php

namespace App\Http\Controllers\Backend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use App\Testimonial;
use DB;
use Hash;
use DataTables;
use Validator;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $testimonial = Testimonial::get();
        return view('admin.testimonial.testimonial')->with(['testimonial'=>$testimonial]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$testimonial = Testimonial::get();
        return view('admin.testimonial.testimonial-create',compact('testimonial'));
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
            'heading'=>'required',
            'title' => 'required|unique:testimonial,title',
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }



        $testimonial = new Testimonial();
        $testimonial->heading = $request->heading;
        $testimonial->title = $request->title;
        $testimonial->desc = $request->desc;

        $image = "";
        if($request->hasFile('image'))
        {
        $image = 'testimonial_'.time().'.'.$request->image->extension();
        $request->image->move(public_path('/uploads/testimonial'), $image);
        $image = "/uploads/testimonial/".$image;
        }
        $testimonial->image = $image ;
        $testimonial->save();


        return response()->json([
            'status' => true,
            'msg' => 'Category created successfully'
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
        $loan = Testimonial::with('parent_detail')->find($id);
        return view('admin.testimonial.testimonial-show',compact('loan'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $testedit = Testimonial::find($id);
        return view('admin.testimonial.testimonial-edit',compact('testedit'));
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
        $validator = Validator::make($request->all(), ['heading'=>'required','title' => 'required']);
        if ($validator->fails()) return response()->json(['status' => false,'errors' => $validator->errors()]);
        $testimonial = Testimonial::find($id);
        $testimonial->heading = $request->heading;
        $testimonial->title = $request->title;
        $testimonial->desc = $request->desc;

        $image = "";
        if($request->hasFile('image'))
        {
        $image = 'testimonial_'.time().'.'.$request->image->extension();
        $request->image->move(public_path('/uploads/testimonial'), $image);
        $image = "/uploads/testimonial/".$image;
        }
        $testimonial->image = $image ;
        $testimonial->save();

        return response()->json(['status' => true,'msg' => 'Category updated successfully']);

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Testimonial::find($id)->delete();
    }



}
