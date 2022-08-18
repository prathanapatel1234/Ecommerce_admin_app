<?php
namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Banner;
use App\Franchise;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use DataTables;
use Validator;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = Banner::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                        $btn = '<a href="'.route("banner-edit", $row->id).'" class="edit btn btn-primary btn-sm">Edit</a>
                        <button type="button" id="deleteButton" data-url="'.route('banner-delete', $row->id).'" class="edit btn btn-primary btn-sm deleteButton" data-loading-text="Deleted...." data-rest-text="Delete">Delete</button>';

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('admin.banner.banner');
    }
    public function export(Request $request){
        $file_name = 'FranchiseList.csv';
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$file_name");
        header("Content-Type: application/csv;");
        $file = fopen('php://output', 'w');
        $header = array('id', 'franchise_name','care_name','email','mobileno','created_at','gstno','city','state');
        fputcsv($file, $header);
        $date='';
        if(!empty($request->datepicker)) $date=$request->datepicker;
        $datas = Franchise::select(['id', 'franchise_name','care_name','email','mobileno','created_at','gstno','city','state'])
                        ->where('created_at','>=',$date)
                        ->get()
                        ->toArray();
                        
        for($i=0;$i<count($datas);$i++){
         $data = array();
         $data[] = $datas[$i]["id"];
         $data[] = $datas[$i]["franchise_name"];
         $data[] = $datas[$i]["care_name"];
         $data[] = $datas[$i]["email"];
         $data[] = $datas[$i]["mobileno"];
         $data[] = $datas[$i]["created_at"];
         $data[] = $datas[$i]["gstno"];
         $data[] = $datas[$i]["city"];
         $data[] = $datas[$i]["state"];
         fputcsv($file, $data);
            
        }
        // foreach($datas as $row)
        // {
        //  $data = array();
        //  $data[] = $row["id"];
        //  $data[] = $row["franchise_name"];
        //  $data[] = $row["care_name"];
        //  $data[] = $row["email"];
        //  $data[] = $row["mobileno"];
        //  $data[] = $row["created_at"];
        //  $data[] = $row["gstno"];
        //  $data[] = $row["city"];
        //  $data[] = $row["state"];
        //  fputcsv($file, $data);
        // }
        fclose($file);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.banner.banner-create',compact(''));
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
            'title' => 'required',
            'banner' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'link' => 'required'
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
		}

		$banner = "";
        if($request->hasFile('banner'))
        {
            $banner = 'banner_'.time().'.'.$request->banner->extension();
            $request->banner->move(public_path('uploads/banner'), $banner);
            $banner =  asset("/public/uploads/banner/".$banner);
        }

        $post = new Banner();
        $post->title = $request->title;
        $post->banner = $banner;
        $post->link = $request->link;
        $post->status = $request->status;
        $post->save();


        return response()->json([
            'status' => true,
            'msg' => 'Banner created successfully'
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
        $post = Banner::find($id);
        return view('admin.banner.banner-edit',compact('post'));
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
            'title' => 'required',
            'banner' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'link' => 'required'
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
		}

		$banner = "";
        if($request->hasFile('banner')){
        $banner = 'banner_'.time().'.'.$request->banner->extension();
        $request->banner->move(public_path('uploads/banner'), $banner);
        $banner =  asset("/public/uploads/banner/".$banner);
        }

        $post = Banner::find($id);
        $post->banner = $banner;
        $post->link = $request->link;
        $post->status = $request->status;
        $post->save();


        return response()->json([
            'status' => true,
            'msg' => 'Banner updated successfully'
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
        Banner::find($id)->delete();
        return response()->json([
            'status' => true,
            'msg' => 'Banner deleted successfully'
			]);
    }
}
