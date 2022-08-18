<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Banner;
use App\Product;
use App\Category;
use App\Testimonial;
use App\FrontUser;
use Hash;
use Session;
use DB;
use Validator;
use App\ProductsVariations;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

     public  function UpdateExcahngeRates($currency){
        $req_url = "https://prime.exchangerate-api.com/v5/3091a1c09c3188662c5b18fd/latest/INR";
        $response_json = file_get_contents($req_url);
        $response = json_decode($response_json);
        if('success' === $response->result) {
           return $response->conversion_rates->$currency;
        }
    }

    public function index()
    {
        $testimonial=Testimonial::cursor();

        $ourproduct=Product::where(['status'=>'approved'])->orderBy('id','DESC')->with('prices')->get();

        $banner=Banner::where(['status'=>1])->get();
       
        // echo "<pre>";print_r($ourproduct[0]->prices->product_mrp_price);
        // exit;
        
        return view('front.home')->with(['testimonial'=>$testimonial,'ourproduct'=>$ourproduct,'banner'=>$banner]);
    }

    public function setCityForUser(Request $request){
        $city=$request->session()->get('LOGGED_CITY');
        if(isset($city)){
            $request->session()->forget('LOGGED_CITY');
            $request->session()->put('LOGGED_CITY', $request->location);
        }
        else   $request->session()->put('LOGGED_CITY', $request->location);
        return response()->json(1);
        //  echo "<pre>";print_r($city);
    }

    public function currency(Request $request){
        $currency=$request->session()->get('currency');
        if(isset($currency)){
            /* Remove Old Currency */
            $request->session()->forget('currency');
            /* Remove Put New Currency */
            $request->session()->put('currency', $request->currency);
            /* Remove Old Rates */
            $request->session()->forget('rates');
            $rates=$this->UpdateExcahngeRates(session()->get('currency'));
            /* Remove Put New Rates */
            $request->session()->put('rates',$rates);
        }
        else  $request->session()->put('currency', $request->currency);
    }

 public function login()
    {
        return view('front.login');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:front_users,email',
            'mobile' => 'required|min:10',
            'password'=>'required'
        ]);
        if($validator->fails()) return redirect()->route('register')->withErrors($validator)->withInput();
        
        $register = new FrontUser();
        $register->name = $request->name;
        $register->email = $request->email;
        $register->mobile = $request->mobile;
        $register->password = bcrypt($request->password);
        $register->save();
       if($register->save()) return redirect()->route('users.dashboard')->withSuccess(['message'=>'You are Registerd Successfully']);
    }

   

    public function register()
    {
        return view('front.register');
    }

    public function getCategoryData(Request $request)
    {
        $category=$request->category;
        $category=Category::where(['title'=>$category])->select(['id'])->first();

        $subCategory=array();
        if($category)    $subCategory=Category::where(['parent_id'=>$category->id])->get();
        // echo "<pre>";print_r($subCategory);
        // exit;
        return view('front.category')->with(['subCategory'=>$subCategory,'title'=>$request->category]);
    }

    public function getProductsByCategory(Request $request){
        $proId=$request->post('id');
        if(!empty($proId)) $data=Product::where(['category_id'=>$proId])->get();
        else                $data=Product::get();
        $html='';
        foreach($data as $key=>$val){
                    ?>
                    <div class="col-md-6 col-lg-3 ftco-animate fadeInUp ftco-animated" >
                        <div class="product">
                            <?php
                             if(!empty($val->sub_category_name))  $route=route('single-product',['category'=>$val->category_name, 'subcategory'=>$val->sub_category_name,'slug'=>$val->slug]);
                             else    $route=route('single-category-product',['category'=>$val->category_name,'slug'=>$val->slug]);
                            ?>
                            <a href="<?=$route?>" class="img-prod">
                              <img class="img-fluid w-100" src="<?php echo url('/public/'.$val->image)?>" alt="Apple Basket">
                                <div class="overlay"></div>
                            </a>
                            <div class="text py-3 pb-4 px-3 text-center">
                                <h3><a href="<?=$route?>"></a></h3>
                                <div class="d-flex">
                                    <div class="pricing">
                                        <p class="price"><span class="mr-2 price-dc">$ 7.8</span><span class="price-sale">$ 6.5</span></p>
                                    </div>
                                </div>
                                <div class="bottom-area d-flex px-3">
                                    <div class="m-auto d-flex">
                                        <form onsubmit="SubmitForm(<?php echo $val->id;?>)" method="POST" id="submitForm<?php echo $val->id;?>" action="<?php echo route('cart.add');?>" class="form-inline my-2 my-lg-0">
                                            <input type="hidden" value="<?php echo csrf_token();?>" name="_token" />
                                            <input name="id" type="hidden" value="4">
                                            <button id="submitButton" class="btn btn-success btn-block" type="submit"><span><i class="ion-ios-cart"></i></span></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
        }
    }
    public function ShopPage(){
        $product=Product::get();
        return view('front.shop')->with(['product'=>$product]);
    }

    public function SingleCategoryProductPage(Request $request){
        $product=Product::where(['category_name'=>$request->category,'slug'=>$request->slug,'status'=>'approved'])
        ->join('product_images','products.id','=','product_images.product_id')
        ->select('products.*','product_images.images')
        ->get();
        
        $relatedproduct=Product::where(['status'=>'approved'])->get();
        return view('front.product-single')->with(['product'=>$product,'relatedproduct'=>$relatedproduct]);
    }
    public function getSubCategoryData(Request $request)
    {
        $city=$request->session()->get('LOGGED_CITY');
        $category=$request->category;
        $subcategory=$request->subcategory;
        $whereCond=array();

        if(isset($city))
        {
             $whereCond[]="category_name='$category'";
             $whereCond[]="sub_category_name='$subcategory'";
             $whereCond[]="find_in_set('$city',location)";
        }
        else
        {
            $whereCond[]="category_name='$category'";
            $whereCond[]="sub_category_name='$subcategory'";
        }
        
        
        $where=implode(' AND ',$whereCond);
        $product=DB::select('select * from products where '.$where);
       
        foreach($product as $key=>$vals)
        {
            
             $productprice = ProductsVariations::where(['product_id'=>$vals->id])->first();
            //  echo "<pre>";
          
             $product[$key]->product_mrp_price = $productprice->product_mrp_price;
             $product[$key]->product_sell_price = $productprice->product_sell_price;
        }
        
        // echo "<pre>";print_r($product);
        // exit;
        // $category=Category::where(['title'=>$category])->select(['id'])->get();
        // print_r($subcategory);die;
        return view('front.sub-category')->with(['product'=>$product,'title'=>$category,'subtitle'=>$subcategory]);
    }


    public function getSingleProductData(Request $request){
        $product=Product::where(['category_name'=>$request->category,'slug'=>$request->slug])
                        ->join('product_images','products.id','=','product_images.product_id')
                        ->select('products.*','product_images.images')
                        ->get();
                        
            foreach($product as $key=>$val){
                $prdvarient = ProductsVariations::where('product_id',$val->id)->first();
                $product[$key]->varient = $prdvarient;
           
            }  
             foreach($product as $key1=>$val1){
                $productvarient = ProductsVariations::where('product_id',$val1->id)->get();
                
           
            } 
            
            
       foreach($product as $key=>$val){
         $relatedproduct=Product::where(['category_id'=>$val->category_id])->get();
         
        
       }
    //   echo "<pre>";print_r($productvarient);die;
        return view('front.product-single')->with(['product'=>$product,'productvarient'=>$productvarient]);
    }

    public function SingleBlogData(Request $request){
       $datas=Blog::where(['slug'=>$request->blogtitle])->get();
        // echo "<pre>";print_r($data);
        // exit;
        return view('front.single-blog')->with(['datas'=>$datas]);
    }


    public function SaveContact(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'mobno'=>'required|unique:contact_us,mobno',
        ]);

        if($validator->fails()) return  redirect('/')->withErrors($validator)->withInput();
        $id=DB::table('contact_us')->insertGetId([
            'name' => $request->name,
            'email' => $request->email,
            'mobno' => $request->mobno,
            'message' => $request->message,
            'created_at'=>date('Y-m-d h:s:i'),
        ]);

        return redirect('/')->with(['message'=>'Data Save Successfully']);
    }
    public function AboutUs()
    {

        return view('front.about-us');
    }
    
    public function changevarient(Request $request)
    {

         return ProductsVariations::where('id',$request->changvar)->first();
    }


}
