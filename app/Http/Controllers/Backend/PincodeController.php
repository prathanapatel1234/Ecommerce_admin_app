<?php
namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pincode;
use App\Franchise;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use DataTables;
use Validator;

class PincodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = Pincode::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<a href="'.route("pincode-edit", $row->id).'" class="edit btn btn-primary btn-sm">Edit</a>
                        <button type="button" id="deleteButton" data-url="'.route('pincode-delete', $row->id).'" class="edit btn btn-primary btn-sm deleteButton" data-loading-text="Deleted...." data-rest-text="Delete">Delete</button>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('admin.pincode.pincode');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pincode.pincode-create',compact(''));
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
            'pincode' => 'required|max:6',
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
		}
        $post = new Pincode();
        $post->pincode = $request->pincode;
        $post->created_at = date("Y-m-d H:i:s");
        $post->status = $request->status;
        $post->save();
        return response()->json([
            'status' => true,
            'msg' => 'Pincode created successfully'
			]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Pincode::find($id);
        return view('admin.pincode.pincode-edit',compact('post'));
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
       $validator = Validator::make($request->all(), [
            'pincode' => 'required',
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
		}

        $post = Pincode::find($id);
        $post->pincode = $request->pincode;
        $post->status = $request->status;
        $post->updated_at = date("Y-m-d H:i:s");
        $post->save();
        return response()->json([
            'status' => true,
            'msg' => 'Pincode updated successfully'
			]);

    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Pincode::find($id)->delete();
        return response()->json([
            'status' => true,
            'msg' => 'Pincode deleted successfully'
			]);
    }
}
