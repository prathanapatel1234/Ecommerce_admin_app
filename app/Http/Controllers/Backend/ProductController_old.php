<?php
namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use App\Product;
use App\ProductsVariations;
use App\Category;
use App\Orders;
use DB;
use Hash;
use DataTables;
use Validator;
use Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
            $product = Product::cursor();
            return view('admin.product.product')->with(['product'=>$product]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function create()
    {
        $product = Product::get();
        $category= Category::where(['parent_id'=>0])->get();
        // dd($category);
        return view('admin.product.product-create')->with(['product'=>$product,'category'=>$category]);
    }

    public function getSubcategory(Request $request){
        // echo $request->id;
        // exit;
        $category= Category::select('id','title')->where(['parent_id'=>$request->id])->get();
        return response()->json($category);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $postData=$request->post();
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required',
            'category_id' => 'required',
            'category_name'=>'required',
            'short_desc'=>'required',
            'location'=>'required',
            'image'=>'required||mimes:jpg,png,jpeg'
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }
        $image = "";
        if($request->hasFile('image'))
        {
            $image = 'singleproduct_'.time().'.'.$request->image->extension();
            $request->image->move(public_path('/uploads/singleproduct'), $image);
            $image = "/uploads/singleproduct/".$image;
        }
        $latest=1;
        if(!isset($request->latest)) $latest=0;
       $id=DB::table('products')->insertGetId([
            'product_name' => $request->name,
            'slug' => $request->slug,
            'category_id' => $request->category_id,
            'category_name'=>$request->category_name,
            'sub_category_id' => $request->sub_category_id,
            'sub_category_name'=>$request->sub_category_name,
            'latest' =>$latest,
            'short_desc'=>$request->short_desc,
            'location'=>implode(',',$request->location),
            'image'=>$image,
            'status'=>$request->status,
            'date'=>date('Y-m-d h:s:i'),
            'created_by'=>Auth::user()->name
        ]);

        foreach($postData['product_weight'] as $key=>$val){
            DB::table('product_variation')->insertGetId([
                'product_id'=>$id,
                'product_weight'=>$val,
                'product_mrp_price'=>$postData['product_mrp_price'][$key],
                'product_sell_price'=>$postData['product_sell_price'][$key],
                'product_total_qty'=>$postData['product_total_qty'][$key],
            ]);
        }

        if($request->hasfile('products_images'))
        {
           foreach($request->file('products_images') as $file)
           {
               $name = 'productsimages_'.time().'.'.$file->extension();
               $file->move(public_path('/uploads/productsimages'),$name);
               $name = "/uploads/productsimages/".$name;
               DB::table('product_images')->insertGetId([
                   'product_id'=>$id,
                   'category_id'=>request('category_id'),
                   'subcategory_id'=>request('sub_category_id'),
                   'images'=>$name,
                   'created_at'=>date('Y-m-d h:s:i')
               ]);
           }
       }


        return response()->json([
            'status' => true,
            'msg' => 'Category created successfully'
			]);

    }

    public function OrdersListing()
    {
        $order=Orders::with('userdetails')->get();
        return view('admin.product.my-orders')->with(['order'=>$order]);
    }

    public function OrdersDetailListing(){
        $orders=Orders::with('orderproducts','userdetails')->get();
        // echo "<pre>";print_r($orders);
        // exit;
        return view('admin.product.orders-detail')->with(['orders'=>$orders]);
    }
    
    public function UpdateOrderStatus(Request $request,$id){
        date_default_timezone_set('Asia/Kolkata');
        $timestamp = date("Y-m-d h:i:s");
        Orders::where(['id'=>$id])->update(['status'=>$request->status,'updated_at'=>$timestamp]);
        if($request->status=='delivered'){
            $wallet = New  Wallet();
            $wallet->user_id=$request->user_id;
            $wallet->order_id=$request->order_id;
            $points  =  ($request->total_price*5)/100;
            $wallet->redemption_points=$points;
            $wallet->redemption_value=$points*0.50;
            $wallet->save();
        }
        return response()->json(['status' => true,'msg' => 'Order updated successfully']);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        $product_variations = ProductsVariations::where(['product_id'=>$id])->get();
        // echo "<pre>";print_r($product);
        // exit;
        return view('admin.product.product-edit')->with(['product'=>$product,'product_variations'=>$product_variations]);
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
        $postData=$request->post();
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required',
            'category_id' => 'required',
            'category_name'=>'required',
            'short_desc'=>'required',
            'location'=>'required',
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }
        $image = "";
        if($request->hasFile('image'))
        {
        $image = 'category_'.time().'.'.$request->image->extension();
        $request->image->move(public_path('/uploads/category'), $image);
        $image = "/uploads/category/".$image;
        }
        else{
            $image=$request->old_image;
        }
        $latest=1;
        if(!isset($request->latest)) $latest=0;
        DB::table('products')->where(['id'=>$id])->update([
            'product_name' => $request->name,
            'slug' => $request->slug,
            'category_id' => $request->category_id,
            'category_name'=>$request->category_name,
            'sub_category_id' => $request->sub_category_id,
            'sub_category_name'=>$request->sub_category_name,
            'latest' =>$latest,
            'short_desc'=>$request->short_desc,
            'location'=>implode(',',$request->location),
            'image'=>$image,
            'status'=>$request->status,
            'date'=>date('Y-m-d h:s:i'),
            'created_by'=>Auth::user()->name
        ]);

        DB::delete('DELETE FROM `product_variation` WHERE product_id='.$id);

        foreach($postData['product_weight'] as $key=>$val){
            DB::table('product_variation')->insertGetId([
                'product_id'=>$id,
                'product_weight'=>$val,
                'product_mrp_price'=>$postData['product_mrp_price'][$key],
                'product_sell_price'=>$postData['product_sell_price'][$key],
                'product_total_qty'=>$postData['product_total_qty'][$key],
            ]);
        }

        if($request->hasfile('products_images'))
        {
            DB::delete('Delete from product_images where product_id='.$id);
           foreach($request->file('products_images') as $file)
           {
               $name = 'productsimages_'.time().'.'.$file->extension();
               $file->move(public_path('/uploads/productsimages'),$name);
               $name = "/uploads/productsimages/".$name;
               DB::table('product_images')->insertGetId([
                   'product_id'=>$id,
                   'category_id'=>request('category_id'),
                   'subcategory_id'=>request('sub_category_id'),
                   'images'=>$name,
                   'created_at'=>date('Y-m-d h:s:i')
               ]);
           }
       }

        return response()->json([
            'status' => true,
            'msg' => 'Product updated successfully'
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
        Product::find($id)->delete();
    }



}
