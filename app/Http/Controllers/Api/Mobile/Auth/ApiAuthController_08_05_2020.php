<?php

namespace App\Http\Controllers\Api\Mobile\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\FrontUser;
use App\User;
use App\Banner;
use App\Category;
use App\ForgotOtp;
use Validator;
use App\Orders;
use App\Product;
use App\OrdersProducts;
use App\Billing;

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
    
    public function Banner(){
        $data=Banner::select('banner','link')->get();
         if(is_object($data) && count($data)>0){
            return $this->sendResponse($data, 'No of Records '.count($data));
        }else{
            return $this->sendError('No Records Found', '');
        }
    }

    public function CategoryData(Request $request){
       $data=Category::where(['parent_id'=>0])->get();
        if(is_object($data) && count($data)>0){
            return $this->sendResponse($data, 'No of Records '.count($data));
        }else{
            return $this->sendError('No Records Found', '');
        }
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
            'categoryid' => 'required',
            'subcategoryid'=>'required',
            'slug'=>'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error', $validator->errors());
        }

        $data=Product::where(['category_id'=>request('categoryid'),'sub_category_id'=>request('subcategoryid'),'slug'=>request('slug')])->get();
        if(is_object($data) && count($data)>0){
            return $this->sendResponse($data, 'No of  Products '.count($data));
        }else{
            return $this->sendError('No Records Found', '');
        }
     }

     public function MyAccount(Request $request){
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
