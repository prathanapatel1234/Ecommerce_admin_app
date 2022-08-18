<?php
namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use App\Product;
use App\ProductsVariations;
use App\Category;
use App\Orders;
use App\FrontUser;
use App\Wallet;
use App\Transactions;
use DB;
use Hash;
use DataTables;
use Validator;
use Auth;
use App\Exports\BulkExport;
use App\Imports\BulkImport;
use Maatwebsite\Excel\Facades\Excel;
use Str;

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
    
    
    public function importProduct(Request $request)
    {   
    //     echo  strtolower($request->file->getMimeType());
        
    //   $validator = Validator::make(
    //     [
    //         'file'      => $request->file,
    //         'extension' => strtolower($request->file->getMimeType()),
    //     ],
    //     [
    //         'file'      => 'required|in:csv',
    //     ]
    // );

//         if ($validator->fails()) {
// 		   return response()->json([
// 			'status' => false,
// 			'errors' => $validator->errors()
// 			]);
//         }
            $upload=$request->file('file');
            $ext = pathinfo($upload->getClientOriginalName(), PATHINFO_EXTENSION);
            if($ext != 'csv')
            return response()->json([
                'status' => false,
                'errors' => 'Selected File Type Is Invalid'
            ]);
            
        
        //get file
        $upload=$request->file('file');
        $ext = pathinfo($upload->getClientOriginalName(), PATHINFO_EXTENSION);
        if($ext != 'csv')
            return redirect()->back()->with('message', 'Please upload a CSV file');

        $filePath=$upload->getRealPath();
        //open and read
        $file=fopen($filePath, 'r');
        $header= fgetcsv($file);
        $escapedHeader=[];
        //validate
        foreach ($header as $key => $value) {
            $lheader=strtolower($value);
            $escapedItem=preg_replace('/[^a-z]/', '', $lheader);
            array_push($escapedHeader, $escapedItem);
        }
        
       
        
        //looping through other columns
        while($columns=fgetcsv($file))
        {
            foreach ($columns as $key => $value) {
                $value=preg_replace('/\D/','',$value);
            }
           $data= array_combine($escapedHeader, $columns);
           
          //echo "<pre>";print_r($columns);
           
           
          $lims_category_data = Category::firstOrCreate(['id' => $data['categoryid'],'title'=>$data['categoryname']]);
           
          $lims_subcategory_data = Category::firstOrCreate(['parent_id' => $data['subcategoryid'],'title'=>$data['subcategoryname']]);

          $product = Product::firstOrNew([ 'product_name'=>$data['productname']]);
           
            if($data['image'])
                $product->image = $data['image'];
            else
                $product->image = 'zummXD2dvAtI.png';

            /*slug*/
            $slug = Str::slug($data['productname']);
            $p = Product::where('slug', $slug)->get();
            if ($p->count() > 0) 
            {
                $slug = $slug .'-'.($p->count() + 1);
            }

          $product->product_name = $data['productname'];
           
          $product->category_id = $lims_category_data->id;
          $product->category_name = $lims_category_data->title;

          $product->slug = $slug;

          $product->sub_category_id = $lims_subcategory_data->id;
          $product->sub_category_name = $lims_subcategory_data->title;
           
          $product->latest = (isset($data['latest']))?$data['latest']:'';
          $product->total_qty = (isset($data['totalqty']))?$data['totalqty']:'';
          $product->mrp_price =  (isset($data['mrpprice']))?$data['mrpprice']:'';
          $product->price =   (isset($data['price']))?$data['price']:'';
          $product->short_desc = (isset($data['shortdesc']))?$data['shortdesc']:'';
          $product->description = (isset($data['description']))?$data['description']:'';
          $product->status = (isset($data['status']))?$data['status']:'';
          $product->updated_at = date('Y-m-d H:i:s');
          $product->created_at = date('Y-m-d H:i:s');
          $product->created_by = auth()->user()->id;
          $product->save();

            if($data['productweight']!=null) 
            {
                //dealing with variants
                $product_weight =     explode(",", $data['productweight']);
                $product_mrp_price =  explode(",", $data['productmrpprice']);
                $product_sell_price = explode(",", $data['productsellprice']);
                $product_total_qty =  explode(",", $data['producttotalqty']);
                $product_image =      explode(",", $data['productimage']);                
                
                foreach ($product_weight as $key => $variant_name) 
                {
                    
                    ProductsVariations::create([
                        'product_id' => $product->id,
                        'product_weight' => $variant_name,
                        'product_mrp_price' => (isset($product_mrp_price[$key]))?$product_mrp_price[$key]:'',
                        'product_sell_price' => (isset($product_sell_price[$key]))?$product_sell_price[$key]:'',
                        'product_total_qty' => (isset($product_total_qty[$key]))?$product_total_qty[$key]:'',
                        'product_image' => (isset($product_image[$key]))?$product_image[$key]:'',
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=>date('Y-m-d H:i:s'),
                    ]);
                }
                
            }
         }
         
         return response()->json([
            'status' => true,
            'msg' => 'Imported Successfull'
			]);
         //return redirect('products')->with('import_message', 'Product imported successfully');
    }
    
    public function bulkUpload(Request $request)
    {
        return view('admin.product.bulk-upload');
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

        
        // echo "<pre>";print_r($request->file);die;
        $postData=$request->all();
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required',
            'category_id' => 'required',
            'category_name'=>'required',
            'short_desc'=>'required',
           
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
            // 'location'=>implode(',',$request->location),
            'image'=>$image,
            'status'=>$request->status,
            'date'=>date('Y-m-d h:s:i'),
            'created_by'=>Auth::user()->name
        ]);

        foreach($postData['product_weight'] as $key=>$val){
            
            $image = 'https://lh3.googleusercontent.com/proxy/QPA46UyTpk5EFCHQzZ4lJZF22MNsJi5byHq_o142w7auh8r_SQew0BpgOCARypz7ro3Qu3c7S5FOyjJetuuoGZZ26mJciC5i76yMEUIBbk9hb_V_n0pS8VFORUVQTkfG';
            $postData['product_image'][$key];
            if(isset($postData['product_image'][$key]) && !empty($postData['product_image'][$key]))
            {

               $file = $postData['product_image'][$key];
               $image = 'productsimages_'.time().$key.'.'.$file->extension();
               $file->move(public_path('/uploads/productsimages'),$image);
               $image = "/uploads/productsimages/".$image;
            }
            
            
            DB::table('product_variation')->insertGetId([
                'product_id'=>$id,
                'product_weight'=>$val,
                'product_mrp_price'=>$postData['product_mrp_price'][$key],
                'product_sell_price'=>$postData['product_sell_price'][$key],
                'product_total_qty'=>$postData['product_total_qty'][$key],
                'product_image'=>$image,
            ]);
            
        }
    
        // echo "d";
        // exit;
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

    public function OrdersDetailListing($id){

        $orders=Orders::where(['id'=>$id])->with('orderproducts','userdetails')->get();
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

            $front =FrontUser::where(['id'=>$request->user_id])->get();
            $user= FrontUser::find($request->user_id);
            $user->wallet_id=$wallet->id;
            $user->redemption_points=$front[0]->redemption_points+$points;
            $user->redemption_value = $front[0]->redemption_value + ($points*0.50);
            $user->save();

            $transction = New Transactions();
            $transction->user_id = $request->user_id;
            $transction->order_id = $request->order_id;
            $transction->trans_type  = 'CR';
            $transction->amount = $points*0.50;
            $transction->save();
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
         $postData=$request->all();
        
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required',
            'category_id' => 'required',
            'category_name'=>'required',
            'short_desc'=>'required',
            // 'location'=>'required',
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
            // 'location'=>implode(',',$request->location),
            'image'=>$image,
            'status'=>$request->status,
            'date'=>date('Y-m-d h:s:i'),
            'created_by'=>Auth::user()->name
        ]);


        DB::delete('DELETE FROM `product_variation` WHERE product_id='.$id);

        if(count($postData['product_weight'])>0)
        {
            foreach($postData['product_weight'] as $key=>$val){
                
                $image = '';
                if(isset($postData['product_image'][$key]) && !empty($postData['product_image'][$key]))
                {
    
                   $file = $postData['product_image'][$key];
                   $image = 'productsimages_'.time().$key.'.'.$file->extension();
                   $file->move(public_path('/uploads/productsimages'),$image);
                   $image = "/uploads/productsimages/".$image;
                }
                
                
                DB::table('product_variation')->insertGetId([
                    'product_id'=>$id,
                    'product_weight'=>$val,
                    'product_mrp_price'=>$postData['product_mrp_price'][$key],
                    'product_sell_price'=>$postData['product_sell_price'][$key],
                    'product_total_qty'=>$postData['product_total_qty'][$key],
                    'product_image'=>$image,
                ]);
                
            }            
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
                   'product_image'=>$image,
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
        return redirect()->route('product-list');
    }

 public function bulkImageUpload(Request $request)
    {
        
        return view('admin.bulkimageupload.bulkimageupload');
    }
    
    
    public function moveBulkImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
           
            'images'=>'required'
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }
         if($request->hasfile('images'))
        {
            
           foreach($request->file('images') as $file)
           {
                
               $name =$file->getClientOriginalName() ;
                
               $file->move(public_path('/uploads/productsimages'),$name);
              
           }
       }
        return response()->json([
            'status' => true,
            'msg' => 'Images Uploaded successfully'
			]);
    }

}
