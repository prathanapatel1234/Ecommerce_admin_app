<?php

namespace App\Http\Controllers\Api\Mobile\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\FrontUser;
use App\User;
use App\Category;
use App\Banner;
use App\ForgotOtp;
use Illuminate\Support\Str;
use Validator;
use App\Orders;
use App\Product;
use App\OrdersProducts;
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
			'status' => false,
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
			'status' => true,
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
        $success['token'] =  $user->createToken('MyApp')->accessToken;

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
			'status' => false,
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
                                ->select('id','name','email','mobile')
                                ->first();
               $tokenResult =$user->createToken('MyApp');
				$token = $tokenResult->token;
				$token->expires_at = Carbon::now()->addWeeks(12);
				$token->save();
				return response()->json([
					'status' => true,
					'data' => $user,
					'access_token' => $tokenResult->accessToken,
					'token_type' => 'Bearer',
					'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
					'message'=>'Login Successfully'
				]);
		   }
		   else
		   {
            return response()->json(['status' => false,'errors' => ['error' => 'Wrong Password']
			]);
		   }
	   }
	   else
	   {
		   return response()->json([
			'status' => false,
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
            return response()->json(['status'=>'true','message'=>'Password Send Successfully On Your E-mail'], 200);
        }
        else          return response()->json(['status'=>'false','message'=>'E-Mail Not Exist'], 200);
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
        return $this->sendResponse($data, 'Time Slot');
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

        foreach($data as $key=>$val){
         if(empty($val->sub_category_id))         $val->sub_category_id='';
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

        public function BaseUrl(){
                    return response()->json(['base_url'=>url('/public/')]);
        }

     public function MyProfile(Request $request){
        $validator = Validator::make($request->all(), [
            'userid' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error', $validator->errors());
        }
        $data=FrontUser::where(['id'=>request('userid')])->select('name','email','mobile','gender','profile_pic')->get();
        if(is_object($data) && count($data)>0){
            return $this->sendResponse($data, 'Data Found Successfully');
        }else{
            return $this->sendError('No Records Found', '');
        }
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

    public function ProceedToCheckout(Request $Request){
        $validator = Validator::make($Request->all(), [
            'userid'=>'required',
            'first_name'=>'required',
            'last_name'=>'required',
            'state'=>'required',
            'city'=>'required',
            'shipping_address'=>'required',
            'zipcode'=>'required',
            'sub_total'=>'required',
            'total_amount'=>'required',
            'mobile_no'=>'required',
            'email'=>'required',
            'pay_type'=>'required',
            'currency_type'=>'required'
        ]);
        if ($validator->fails())
        {
            return response()->json([
             'status' => false,
             'errors' => $validator->errors()
             ]);
         }

        Billing::insertgetId([
            'user_id'=>$Request->post('userid'),
            'first_name'=>$Request->post('first_name'),
            'last_name'=>$Request->post('last_name'),
            'state'=>$Request->post('state'),
            'city'=>$Request->post('city'),
            'address'=>$Request->post('shipping_address'),
            'zipcode'=>$Request->post('zipcode'),
            'pay_type'=>$Request->post('pay_type'),
            'sub_total'=>$Request->post('sub_total'),
            'delivery_charges'=>$Request->post('delivery_charges'),
            'discount'=>$Request->post('discount'),
            'total_amount'=>$Request->post('total_amount')+$Request->post('delivery_charges')+$Request->post('discount'),
            'mobile_no'=>$Request->post('mobile_no'),
            'email'=>$Request->post('email'),
            'status'=>'pending',
            'created_at'=>date('Y-m-d h:s:i')
        ]);

        $lastId=DB::table('order_details')->insertgetId([
            'user_id'=>$Request->post('userid'),
            'order_id'=>'orderid',
            'payment_id'=>$Request->post('payment_id'),
            'status'=>'order recieved',
            'currency_type'=>$Request->post('currency_type'),
            'total_amount'=>$Request->post('total_amount')+$Request->post('delivery_charges')+$Request->post('discount'),
            'created_at'=>date('Y-m-d h:s:i')
        ]);

        DB::table('order_details')->where(['id'=>$lastId])->update(['order_id'=>'ORDER'.$lastId]);
        $dummyOrders=array(
            0=>[
                'id'=>2,
                'name'=>'SESAME SEEDS / तिल के बीज BLACK',
                'price'=>200,
                'quantity'=>4,
                'created_at'=>date('Y-m-d h:s:i')
            ],
            1=>[
                'id'=>4,
                'name'=>'SESAME SEEDS / तिल के बीज RED',
                'price'=>200,
                'quantity'=>4,
                'created_at'=>date('Y-m-d h:s:i')
            ],
        );


        foreach($dummyOrders as $key=>$product){
            //echo $product->quantity*$product->price."<br />";
            DB::table('order_products')->insertgetId([
                'order_id'=>'ORDER'.$lastId,
                'product_id'=>$product['id'],
                'product_name'=>$product['name'],
                'price'=>$product['price'],
                'total_price'=>$product['quantity']*$product['price'],
                'quantity'=>$product['quantity'],
                'created_at'=>date('Y-m-d h:s:i')
            ]);
         }
        return response()->json(['status'=>'true','message'=>'Order Place Successfully']);
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

        if($validator->fails()){
            return $this->sendError('Validation Error', $validator->errors());
        }

        $data=Orders::where(['user_id'=>request('userid')])->get();
        if(is_object($data) && count($data)>0){
            return $this->sendResponse($data, 'User Found Successfully');
        }else{
            return $this->sendError('No Records Found', '');
        }
     }

     public function MyOrdersDetails(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'order_id'=>'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error', $validator->errors());
        }

        $data=Orders::where(['order_details.order_id'=>request('order_id'),'order_details.user_id'=>request('user_id')])->with('orderproducts','userdetails')->get();
        if(is_object($data) && count($data)>0){
            return $this->sendResponse($data, 'User Found Successfully');
        }else{
            return $this->sendError('No Records Found', '');
        }
     }









	public function verifyLoginOtp(Request $request)
    {
		$validator = Validator::make($request->all(), [
            'mobile' => 'required|numeric|digits:10|exists:forgot_otp,mobile',
            'otp' => 'required'
        ]);
		if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }

		$matchOtp = ForgotOtp::where('mobile', $request->mobile)->whereDate('created_at', Carbon::today())->where('otp', $request->otp)->first();
		if(!$matchOtp){

			return response()->json([
			'status' => false,
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
			'status' => true,
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
					'status' => true,
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
			'status' => false,
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
			'status' => true,
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
			'status' => false,
			'errors' => $validator->errors()
			]);
        }

		$matchOtp = ForgotOtp::where('mobile', $request->mobile)->whereDate('created_at', Carbon::today())->where('otp', $request->otp)->first();
		if(!$matchOtp){

			return response()->json([
			'status' => false,
			'errors' => ['otp'=> ['Wrong Otp.']]
			]);

		}else{
			ForgotOtp::where('mobile', $request->mobile)->delete();
		}

		//change password
		$user = ApiUser::where('mobile', $request->mobile)->update(['password' => Hash::make($request->password)]);

		return response()->json([
			'status' => true,
			'message' => 'Password Updated.'
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
