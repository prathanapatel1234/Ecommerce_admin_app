<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Orders;
use App\Products;
use App\OrdersProducts;
use App\FrontUser;
use App\Billing;
use Validator;
use DB;


class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
         $this->middleware('isLogin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('front.dashboard');
    }
    public  function myorders(Request $request){

        $order=Orders::where(['user_id'=>$request->session()->get('LOGGED_ID')])
         ->get();
        //  echo "<pre>";print_r($order);
        //  exit;
        return view('front.my-orders')->with(['order'=>$order]);
    }

    public  function myProfile(Request $request){
        $user=FrontUser::find($request->session()->get('LOGGED_ID'));
        return view('front.my-profile')->with(['user'=>$user]);
    }

    public function UpdateUser(Request $request,$id){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'email|required',
            'mobile' => 'required',
        ]);

        if($validator->fails()) return redirect()->route('my.profile')->withErrors($validator)->withInput();

        if($request->hasFile('profile')){
        $profile = 'profile_'.time().'.'.$request->profile->extension();
        $request->profile->move(public_path('uploads/profile'), $profile);
        $profile = "/public/uploads/profile/".$profile;
        }
        else       $profile =$request->old_image;

        $post = FrontUser::find($id);
        $post->name = $request->name;
        $post->email = $request->email;
        $post->mobile = $request->mobile;
        $post->gender = $request->gender;
        $post->profile_pic = $profile;
        $post->updated_at = date('Y-m-d h:s:i') ;
        $post->save();
        return redirect()->route('my.profile')->with(['message'=>'Profile Update Successfully']);
    }

    public function OrderDetails(Request $request,$orderid){
        //$orderDetails=Orders::where(['order_id'=>$orderid])->with('orderproducts')->get();
        $orderDetails=Orders::where(['order_details.order_id'=>$orderid,'order_details.user_id'=>session()->get('LOGGED_ID')])->with('orderproducts','userdetails')->get();
        return view('front.orders-details')->with(['orderDetails'=>$orderDetails]);
    }


}
