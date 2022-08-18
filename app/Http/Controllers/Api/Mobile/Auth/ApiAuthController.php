<?php

namespace App\Http\Controllers\Api\Mobile\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\FrontUser;
use App\User;
use App\Pincode;
use App\Offer;
use App\Category;
use App\Transactions;
use App\Banner;
use App\ForgotOtp;
use Illuminate\Support\Str;
use Validator;
use App\Orders;
use App\Product;
use App\OrdersProducts;
use App\ProductsVariations;
use App\Billing;
use Mail;
use DB;
class ApiAuthController extends Controller
{


	//send Login otp
	public function sendLoginOtp(Request $request)
    {
		$validator = Validator::make($request->all(), [
            'mobile' => 'required|numeric|digits:10',
        ]);
		if ($validator->fails()) {
		   return response()->json([
			'success' => false,
			'errors' => $validator->errors()
			]);
        }

		//send otp
		$otp = rand(1000,9999);
		$signature = $request->signature;
        $this->sendSMS("<#> Your OTP is: ".$otp." ".$signature, $request->mobile);

		// forgot otp table also use for verify mobile
		$saveotp = new ForgotOtp;
		$saveotp->mobile = $request->mobile;
		$saveotp->otp = $otp;
		$saveotp->save();

		return response()->json([
			'success' => true,
			'msg' => 'Otp Send success'
			]);

    }
    
    
    public function sendResponse($result, $message)
    {
    	$response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
    	$response = [
            'success' => false,
            'message' => $error,
        ];


        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }


        return response()->json($response, $code);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:front_users,email',
            'password' => 'required',
            'mobile' => 'required|numeric|digits:10|unique:front_users,mobile',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();

        $input['password'] = bcrypt($input['password']);
        $user = FrontUser::create($input);
        $success['id'] =  $user->id;
        $success['name'] =  $user->name;
        $success['email'] =  $user->email;
        $success['mobile'] =  $user->mobile;
        $success['redemption_points'] =  ($user->redemption_points>0)?$user->redemption_points:0;
        $success['redemption_value'] =   ($user->redemption_value>0)?$user->redemption_value:0;
        $success['access_token'] =  $user->createToken('MyApp')->accessToken;

        return $this->sendResponse($success, 'User register successfully.');
    }

    public function login(Request $request)
    {

        if(preg_match('/^[0-9]{10}+$/', $request->post('input')))
        {
            $cred['mobile']=$request->input;
            $validation['input']='required|numeric|digits:10';
            $validation['password']='required';
            $error="Mobile No. Not Exist";
        }
        else{
            $cred['email']=$request->input;
            $validation['input']='required|email';
            $validation['password']='required';
            $error="E-mail ID Not Exist";
        }

        // echo "<pre>";print_r($cred);
        // exit;
        	$validator = Validator::make($request->all(), $validation);
        if ($validator->fails()) {
		   return response()->json([
			'success' => false,
			'errors' => $validator->errors()
			]);
        }
        $user = FrontUser::where($cred)
                      ->select('email','password')
                      ->first();
                    //   echo "<pre>";print_r($user);
                    //   exit;
       if($user)
       {
           if (Hash::check($request->password,$user->password))
           {
               $user = FrontUser::where($cred)
                        ->select('id','name','email','mobile','redemption_points','redemption_value')
                        ->first();
               $tokenResult =$user->createToken('MyApp');
				$token = $tokenResult->token;
				$token->expires_at = Carbon::now()->addWeeks(12);
				$token->save();
				return response()->json([
					'success' => true,
					'data' => $user,
					'access_token' => $tokenResult->accessToken,
					'token_type' => 'Bearer',
					'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
                    'message'=>'Login Successfully',

				]);
		   }
		   else
		   {
            return response()->json(['success' => false,'errors' => ['error' => 'Wrong Password']
			]);
		   }
	   }
	   else
	   {
		   return response()->json([
			'success' => false,
			'errors' => ['error' => $error]
			]);
       }
    }

    public function random_strings($length_of_string)
    {

        // String of all alphanumeric character
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

        // Shufle the $str_result and returns substring
        // of specified length
        return substr(str_shuffle($str_result),  0, $length_of_string);
    }

    public function ForgotPassword(Request $request ){
        $validator = Validator::make($request->all(), [
            'email' => 'required',
        ]);

        if($validator->fails()) return $this->sendError('Validation Error', $validator->errors());

        $postData=$request->post();
        $frontUser=FrontUser::where(['email'=>$request->email])->count();
        if($frontUser>0){
                $email=$request->email;
                $message='Your  Password :'.$this->random_strings(10);
                $data=array('email'=>$email,'bodyMessage'=>$message);
                $mail=Mail::send('admin.emails.mail',$data,function($message) use ($email){
                        $message->to($email)->subject('Forgot Password');
                    });
                $msg='';
            return response()->json(['success'=>'true','message'=>'Password Send Successfully On Your E-mail'], 200);
        }
        else          return response()->json(['success'=>'false','message'=>'E-Mail Not Exist'], 200);
    }

    public function CategoryData(Request $request){
       $data=Category::where(['parent_id'=>0])->get();
       $data=$this->removeEmptyValues($data);
        if(is_object($data) && count($data)>0){
            return $this->sendResponse($data, 'No of Records '.count($data));
        }else{
            return $this->sendError('No Records Found', '');
        }
    }

 function removeEmptyValues($array){
    foreach ($array as $key => $value) {
        foreach($value as $k=>$val){
            if(empty($val)){
                $val='';
            }
        }
    }
    return $array;
  }


    public function MinimumCart(Request $request){
        $data = DB::table('minimum_cart')->select('cart_value')->get();
        return $this->sendResponse($data, 'Minimum Cart Value');
    }

    public function TimeSlots(Request $request){
        $data = DB::table('time_slot')->select('id','time_slot','date')->get();
        //$pincode=Pincode::get();
        //,'pincode'=>$pincode
        return response()->json(['success'=>true,'data'=>$data]);
    }


    public function LatestProducts(Request $request){
        $data = Product::where(['latest'=>1])->get();
        return $this->sendResponse($data, 'Latest Products');
    }


    public function SubCategoryData(Request $request){
        $validator = Validator::make($request->all(), [
            'categoryid' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error', $validator->errors());
        }

        $data=Category::where(['parent_id'=>request('categoryid')])->get();
        if(is_object($data) && count($data)>0){
            return $this->sendResponse($data, 'No of Records '.count($data));
        }else{
            return $this->sendError('No Records Found', '');
        }
     }

     public function SubCategoryProducts(Request $request){
        $validator = Validator::make($request->all(), [
            'categoryid' => 'required',
            'subcategoryid'=>'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error', $validator->errors());
        }

        $data=Product::where(['category_id'=>request('categoryid'),'sub_category_id'=>request('subcategoryid')])->get();
        
        if(is_object($data) && count($data)>0){
            foreach($data as $key=>$val){
                $provar=ProductsVariations::where(['product_id'=>$val->id])->first();
                        DB::table('products')->where(['id'=>$provar->product_id])->update([
                            'mrp_price'=>$provar->product_mrp_price,
                            'price'=>$provar->product_sell_price,
                            'total_qty'=>$provar->product_total_qty,
                            ]);
                
                }
        foreach($data as $key=>$val){
         if(empty($val->sub_category_id))         $val->sub_category_id='';
         if(empty($val->status))                  $val->status='';
         if(empty($val->sub_category_name))       $val->sub_category_name='';
         if(empty($val->ip))                      $val->ip='';
         if(empty($val->description))             $val->description='';
         if(empty($val->short_desc))             $val->short_desc='';
         if(empty($val->created_by))             $val->created_by='';
        }
 //          $data=Product::where(['category_id'=>request('categoryid'),'sub_category_id'=>request('subcategoryid')])->get();
            return $this->sendResponse($data, 'No of Products '.count($data));
        }else{
            return $this->sendError('No Records Found', '');
        }
     }

     public function SubCategorySingleProducts(Request $request){
        $validator = Validator::make($request->all(), [
                'proid' => 'required',
            ]);

        if($validator->fails())          return $this->sendError('Validation Error', $validator->errors());

        $data=Product::where(['id'=>request('proid')])->with('products_variations')->get();
    // echo "<pre>";print_r($data);
    //     exit;
        foreach($data as $key=>$val){
         if(empty($val->sub_category_id))         $val->sub_category_id='';
         if(empty($val->status))                  $val->status='approved';
         if(empty($val->sub_category_name))       $val->sub_category_name='';
         if(empty($val->ip))                      $val->ip='';
         if(empty($val->description))             $val->description='';
         if(empty($val->short_desc))             $val->short_desc='';
         if(empty($val->created_by))             $val->created_by='';
        }

        // echo "<pre>";print_r($data);
        // exit;
        if(is_object($data) && count($data)>0){
            return $this->sendResponse($data, 'No of  Products '.count($data));
        }else{
            return $this->sendError('No Records Found', '');
        }
     }

    public function Pincode(Request $request){

       $pincode = Pincode::where(['pincode'=>$request->pincode])->count();
       if($pincode==0) return response()->json(['success'=>'false','message'=>'Product Not Available in This Area']);
       else            return response()->json(['success'=>'true','message'=>'Product Available in This Area']);

    }



        public function BaseUrl(){   return response()->json(['base_url'=>url('/public/')]);}

     public function MyProfile(Request $request){
        $validator = Validator::make($request->all(), [
            'userid' => 'required',
        ]);

        if($validator->fails())  return $this->sendError('Validation Error', $validator->errors());
        $data=FrontUser::select('name','email','mobile','gender','profile_pic')->find(request('userid'));
        if(is_object($data))    return $this->sendResponse($data, 'Data Found Successfully');
        else                    return $this->sendError('No Records Found', '');
     }

     public function UpdatedMyProfile(Request $request){
        $validator = Validator::make($request->all(), [
            'userid' => 'required',
            'name'=>'required',
            'mobile'=>'required',
            'email'=>'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error', $validator->errors());
        }

        if($request->hasFile('profile')){
        $profile = 'profile_'.time().'.'.$request->profile->extension();
        $request->profile->move(public_path('uploads/profile'), $profile);
        $profile = "/public/uploads/profile/".$profile;
        }
        else       $profile =$request->old_image;

        if(empty($request->gender))     $request->gender='';
        if(empty($profile))             $profile='';

        $post = FrontUser::find($request->userid);
        $post->name = $request->name;
        $post->email = $request->email;
        $post->mobile = $request->mobile;
        $post->gender = $request->gender;
        $post->profile_pic = $profile;
        $post->updated_at = date('Y-m-d h:s:i') ;
        $post->save();

        // echo "<pre>";print_r($post);
        // exit;
        return $this->sendResponse($post, 'Profile Update Successfully');
     }

     public function ProceedToCheckout(Request $request){
        // echo "<pre>";print_r($request->post());
        // exit;
        $validator = Validator::make($request->all(), [
            'product_id.*'=>'required',
            'product_name.*'=>'required',
            'price.*'=>'required',
            'quantity.*'=>'required',
        ]);
        if ($validator->fails())
        {
            return response()->json([
             'success' => false,
             'errors' => $validator->errors()
             ]);
         }

       $check = DB::table('cart_data')->where(['user_id'=>$request->post('userid')])->count();
        if($check==0){
            foreach($request->post('data') as $key=>$product){
                DB::table('cart_data')->insertgetId([
                    'user_id'=>$request->post('userid'),
                    'product_id'=>$product['id'],
                    'product_name'=>$product['name'],
                    'price'=>$product['price'],
                    'quantity'=>$product['quantity'],
                    'total_price'=>$product['quantity']*$product['price'],
                    'created_at'=>date('Y-m-d h:i:s')
                ]);
             }
        }
        else{

            $userid=$request->post('userid');
            DB::delete("DELETE FROM `cart_data` WHERE `user_id` = '$userid'");
            foreach($request->post('data') as $key=>$product){
                DB::table('cart_data')->insertgetId([
                    'user_id'=>$request->post('userid'),
                    'product_id'=>$product['id'],
                    'product_name'=>$product['name'],
                    'price'=>$product['price'],
                    'quantity'=>$product['quantity'],
                    'total_price'=>$product['quantity']*$product['price'],
                    'created_at'=>date('Y-m-d h:i:s')
                ]);
             }

        }
         return response()->json(['success'=>'true','message'=>'Checkout Successfully']);
     }

    public function saveOrder(Request $Request){

        $validator = Validator::make($Request->all(), [
            'userid'=>'required',
            'name'=>'required',
            'shipping_address'=>'required',
            'pincode'=>'required',
            'area'=>'required',
            'delivery_date'=>'required',
            'delivery_time'=>'required',
            'total_amount'=>'required',
        ]);

        if ($validator->fails())    return response()->json(['success' => false,'errors' => $validator->errors()]);
        $user = FrontUser::find($Request->post('userid'));

        Billing::insertgetId([
            'user_id'=>$Request->post('userid'),
            'first_name'=>$user->name,
            'last_name'=>$Request->post('last_name'),
            'state'=>$Request->post('state'),
            'city'=>$Request->post('city'),
            'address'=>$Request->post('shipping_address'),
            'zipcode'=>$Request->post('pincode'),
            'pay_type'=>$Request->post('pay_type'),
            'sub_total'=>$Request->post('sub_total'),
            'delivery_charges'=>$Request->post('delivery_charges'),
            'discount'=>$Request->post('discount'),
            'total_amount'=>$Request->post('total_amount')+$Request->post('delivery_charges')+$Request->post('discount'),
            'mobile_no'=>$user->mobile,
            'email'=>$user->email,
            'success'=>'pending',
            'created_at'=>date('Y-m-d h:s:i')
        ]);
        $promo_code='';
        $promo_amt=0;
        $redeem_points='';
        $redeem_amt='';
        
        if(isset($Request->promo_code)) $promo_code = $Request->promo_code;
        if(isset($Request->promo_amt)) $promo_amt = $Request->promo_amt;

        if(isset($Request->redeem_points)) $redeem_points = $Request->redeem_points;
        if(isset($Request->redeem_amt)) $redeem_amt = $Request->redeem_amt;

        $lastId=DB::table('order_details')->insertgetId([
            'user_id'=>$Request->post('userid'),
            'order_id'=>'orderid',
            'success'=>'order recieved',
            'currency_type'=>'INR',
            'total_amount'=>$Request->post('total_amount')-$promo_amt,
            'delivery_date'=>$Request->post('delivery_date'),
            'delivery_time'=>$Request->post('delivery_time'),
            'promo_code'=>$redeem_amt,
            'promo_amt'=>$promo_amt,
            'redeem_points'=>$redeem_points,
            'redeem_amt'=>$redeem_amt,
            'created_at'=>date('Y-m-d h:s:i')
        ]);

        DB::table('order_details')->where(['id'=>$lastId])->update(['order_id'=>'ORDER'.$lastId]);
        
        
     if(isset($Request->redeem_points) && isset($Request->redeem_amt)){
        $user = FrontUser::find($Request->post('userid'));
        $redempoint = $user->redemption_points - $redeem_points;
        $redemamt = $user->redemption_value - $redeem_amt;
       
        FrontUser::where(['id'=>$Request->post('userid')])->update(['redemption_points'=>$redempoint,'redemption_value'=>$redemamt]);
        
        $trans = New Transactions();
        $trans->user_id=$Request->post('userid');
        $trans->order_id='ORDER'.$lastId;
        $trans->trans_type='DR';
        $trans->amount=$Request->redeem_amt;
        }

        if(is_array(json_decode($Request->post('data'))) && count(json_decode($Request->post('data')))>0)
        {
            foreach(json_decode($Request->post('data')) as $key=>$product)
            //  foreach($Request->post('data') as $key=>$product)
             {
                $proimagge=Product::find(['id'=>$product->id]);
                if(empty($proimagge->image)) $proimagge->image='';
                DB::table('order_products')->insertgetId([
                    'order_id'=>'ORDER'.$lastId,
                    'product_id'=>$product->id,
                    'product_name'=>$product->name,
                    'price'=>$product->price,
                    'total_price'=>$product->quantity*$product->price,
                    'quantity'=>$product->quantity,
                   
                ]);
             }
         }
         else      return response()->json(['success'=>'false','message'=>'Cart is Empty']);
        return response()->json(['success'=>'true','message'=>'Cart Successfully saved','order_id'=>'ORDER'.$lastId]);
    }
    
    
     public function Promocode(Request $Request){
        $validator = Validator::make($Request->all(), [
            'amount'=>'required',
            'promocode'=>'required',
        ]);

    if ($validator->fails())    return response()->json(['success' => false,'errors' => $validator->errors()]);
     $offer =  Offer::where(['offer_name'=>$Request->promocode])->get();
     if(is_object($offer) && count($offer)>0){
            if($offer[0]->coupon_type==1){
                    if($Request->amount >= $offer[0]->receipt_amt){
                        $disamt = $Request->amount-$offer[0]->discount_amountoff;
                        return response()->json(['success'=>'true','data'=>number_format($offer[0]->discount_amountoff,2) ,'message'=>'Coupon Code Applied']);
                    }
                    else{
                        return response()->json(['success'=>'true','message'=>'Cart Amount is Smaller Than Required Amount']);
                    }
            }
            else{
                if($Request->amount >= $offer[0]->receipt_amt){
                    $percentageAmt = ($Request->amount  * $offer[0]->discount_percentage)/100;
                    $disamt=$Request->amount-$percentageAmt;
                    return response()->json(['success'=>'true','data'=>number_format($percentageAmt,2) ,'message'=>'Coupon Code Applied']);
                }
                else{
                    return response()->json(['success'=>'true','message'=>'Cart Amount is Smaller Than Required Amount']);
                }
            }
     }
     else       return response()->json(['success'=>'false','message'=>'Invalid Coupon Code']);
    }
    
     public function Transctions(Request $request){
         	$validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);
		if ($validator->fails())   return response()->json(['success' => false,'errors' => $validator->errors()]);
         $data = Transactions::where(['user_id'=>$request->user_id])->get();
         foreach($data as $key=>$val){
             if(empty($val->transaction_id)) $val->transaction_id='';
             if(empty($val->payment_type)) $val->payment_type='';
         }
         return response()->json(['success'=>'true','data'=>$data]);
     }
     
     public function TransType(Request $request){
                 
     }
     
    public function PaymentSuccess(Request $Request){
        $validator = Validator::make($Request->all(), [
            'user_id'=>'required',
            'order_id'=>'required'
            ]);
            // echo $Request->payment_id;
            // exit;
        if ($validator->fails())  return response()->json(['success' => false,'errors' => $validator->errors()]);
       if(isset($Request->payment_id)){
        
        $data= DB::table('order_details')->where(['order_id'=>$Request->order_id,'user_id'=>$Request->user_id])->update(['payment_id'=>$Request->payment_id]);  
        
        DB::table('billing_details')->where(['user_id'=>$Request->user_id])->update(['pay_type'=>'Prepaid']);
        
        //Transactions::where(['user_id'=>$Request->user_id,'order_id'=>$Request->order_id])->update(['payment_id'=>$Request->payment_id]);
        
        if($data==1)            return response()->json(['success'=>true,'message'=>'Payment Successfull']);
        else                    return response()->json(['success'=>false,'message'=>'Payment Error']);
       }
       else
       {
        $data= DB::table('billing_details')->where(['user_id'=>$Request->user_id])->update(['pay_type'=>'COD']);           
        return response()->json(['success'=>true,'message'=>'Cash On Delivery Successfully']);
       }
    }


    public function BannerData(){
        $data=Banner::select('title','banner','link')->get();
        return response()->json(['success'=>'true','data'=>$data]);
    }

    public function OrderPayment(){   }


     public function MyOrders(Request $request){
        $validator = Validator::make($request->all(), [
            'userid' => 'required',
        ]);
        if($validator->fails())          return $this->sendError('Validation Error', $validator->errors());
        $data=Orders::where(['user_id'=>request('userid')])->orderBy('id', 'DESC')->get();
        foreach($data as $key=>$val)
        {
            if(empty($val->payment_id)) $val->payment_id='';
            if(empty($val->updated_at)) $val->updated_at=$val->created_at;
        }
        
        if(is_object($data) && count($data)>0)        return $this->sendResponse($data, 'User Orders');
        else                                          return $this->sendError('No Records Found', '');
     }

     public function MyOrdersDetails(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'order_id'=>'required'
        ]);
        if($validator->fails())          return $this->sendError('Validation Error', $validator->errors());
        
        $data=Orders::where(['order_details.order_id'=>request('order_id'),'order_details.user_id'=>request('user_id')])
                      ->with('orderproducts')
                      ->orderBy('id', 'DESC')
                      ->get();
                      
        foreach($data as $ordkey=>$ordval){
            if(empty($ordval->payment_id)) $ordval->payment_id='';
            foreach($ordval->orderproducts as $key=>$val){
                $proimage=Product::select('image')->find($val->product_id);
                if(!empty($proimage->image))    $val['image']=$proimage->image;
                else $val['image']='';
            }
        }
        // echo "<pre>";print_r($data);
        // exit;
        if(is_object($data) && count($data)>0)           return $this->sendResponse($data, 'Order Details');
        else                                            return $this->sendError('No Records Found', '');

     }
     


	public function verifyLoginOtp(Request $request)
    {
		$validator = Validator::make($request->all(), [
            'mobile' => 'required|numeric|digits:10|exists:forgot_otp,mobile',
            'otp' => 'required'
        ]);
		if ($validator->fails()) {
		   return response()->json([
			'success' => false,
			'errors' => $validator->errors()
			]);
        }

		$matchOtp = ForgotOtp::where('mobile', $request->mobile)->whereDate('created_at', Carbon::today())->where('otp', $request->otp)->first();
		if(!$matchOtp){

			return response()->json([
			'success' => false,
			'message' => 'Wrong Otp'
			]);

		}else{
			ForgotOtp::where('mobile', $request->mobile)->delete();
		}

		//if user not registor
		$exist = User::where('mobile_no', $request->mobile)->first();
		if(!isset($exist->name)){
			$User = new User();
			$User->mobile_no = $request->mobile;
			$User->save();

			return response()->json([
			'success' => true,
			'type' => 'registor',
			'message' => 'Otp Verify'
			]);
		}else{
			$user = User::where("mobile_no",$request->mobile)->first();
			$tokenResult = $user->createToken('Personal Access Token');
				$token = $tokenResult->token;
				$token->expires_at = Carbon::now()->addWeeks(12);
				$token->save();
				return response()->json([
					'success' => true,
					'type' => 'login',
					'user' => $user,
					'access_token' => $tokenResult->accessToken,
					'token_type' => 'Bearer',
					'expires_at' => Carbon::parse(
						$tokenResult->token->expires_at
					)->toDateTimeString()
				]);
		}



    }

	public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }


	//send forgot password otp
	public function sendOtp(Request $request)
    {
		$validator = Validator::make($request->all(), [
            'mobile' => 'required|numeric|digits:10',
        ]);
		if ($validator->fails()) {
		   return response()->json([
			'success' => false,
			'errors' => $validator->errors()
			]);
        }

		//send otp
		$otp = rand(1000,9999);
        $this->sendSMS("Your OTP ".$otp." Please use for change password", $request->mobile);
		$saveotp = new ForgotOtp;
		$saveotp->mobile = $request->mobile;
		$saveotp->otp = $otp;
		$saveotp->save();




		return response()->json([
			'success' => true,
			'msg' => 'Otp Send success'
			]);

    }


	public function passwordSet(Request $request)
    {
		$validator = Validator::make($request->all(), [
            'mobile' => 'required|numeric|digits:10|exists:api_users',
            'otp' => 'required',
            'password' => 'required|confirmed|min:6'
        ]);
		if ($validator->fails()) {
		   return response()->json([
			'success' => false,
			'errors' => $validator->errors()
			]);
        }

		$matchOtp = ForgotOtp::where('mobile', $request->mobile)->whereDate('created_at', Carbon::today())->where('otp', $request->otp)->first();
		if(!$matchOtp){

			return response()->json([
			'success' => false,
			'errors' => ['otp'=> ['Wrong Otp.']]
			]);

		}else{
			ForgotOtp::where('mobile', $request->mobile)->delete();
		}

		//change password
		$user = ApiUser::where('mobile', $request->mobile)->update(['password' => Hash::make($request->password)]);

		return response()->json([
			'success' => true,
			'message' => 'Password Updated.'
			]);

    }


    public function wallet(Request $request){
        $data = DB::table('wallet')
                        ->select(DB::raw('sum(redemption_points) AS `total` , sum(redemption_value) AS `redeem_total` '))
                        ->where(['user_id'=>$request->user_id])
                        ->first();
        $total=0;
        $redeemtotal=0;
        if($data)
        {
            if($data->total>0)          $total = $data->total;
            if($data->redeem_total>0)   $redeemtotal =  $data->redeem_total;
        }
        
        return response()->json([
            'success' => true,
            'wallet'=>$total,
            'value_inr'=>$redeemtotal,
			'message' => 'Sum of Redemptions Points'
			]);
    }
    
	public function sendSMS($message, $mobile){

        $endpoint = "http://prosms.easy2approach.com/api/sendhttp.php";
        $client = new \GuzzleHttp\Client();
        $params['query'] = array(
		'authkey' => '4669Atyt2mgj1RV35943a18f',
		'mobiles' => $mobile,
		'message' => $message,
		'sender' => 'UDRBZR',
		'route' => '4',
		'country' => '91'
		);

        $response = $client->get( $endpoint, $params);
        $content = $response->getBody()->getContents();
        return $content;
    }



}
