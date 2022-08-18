<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use App\Fundraise;
use Session;
use Validator;
use App\User;
use App\FrontUser;

class LoginController extends Controller
{
        public function checkLogin(Request $request){
            $validator = Validator::make($request->all(), [
                'password'=>'required',
                'email'=>'required'
            ]);
            if ($validator->fails()) {
                return response()->json([
                 'status' => false,
                 'errors' => $validator->errors()
                 ]);
             }
            else
            {
                $user = FrontUser::where(['email'=>$request->email])->first();
                if(is_object($user))
                {
                   if (Hash::check($request->password,$user->password))
                    {

                        $data=session([
                                'LOGGED_ID'=>$user->id,
                                'LOGGED_NAME'=>$user->name,
                                'LOGGED_MOBNO'=>$user->mobile,
                                'LOGGED_EMAIL'=>$user->email,
                                'LOGGED_USERTYPE'=>'user'
                        ]);
                        //  echo "<pre>";print_r(session()->all());
                        //  exit;
                        return redirect()->route('users.dashboard');
                    }
                    else return redirect()->route('login')->with(['err_message'=>'Incorrect Password']);
                }
                 else return redirect()->route('login')->with(['err_message'=>'Invalid User Credentials']);
        }
    }
    public function logout(Request $request){
        $request->session()->forget(
            [
            'LOGGED_ID',
            'LOGGED_NAME',
            'LOGGED_MOBNO',
            'LOGGED_EMAIL',
            'LOGGED_USERTYPE'
            ]);
            return redirect()->route('home');
        //  echo "<pre>";print_r(session()->all());
        //  exit;
    }
        protected function redirectTo(){    }
}
