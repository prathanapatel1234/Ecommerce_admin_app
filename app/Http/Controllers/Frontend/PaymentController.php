<?php

namespace App\Http\Controllers\Frontend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Cart;
use Session;
use App\Product;
use App\Orders;
use Validator;
use DB;
use App\Billing;
class PaymentController extends Controller
{

    public function currencySet($amt){
        $currency=session()->get('currency');
         if($currency=='USD') return $amt*0.013;
         elseif($currency=='INR') return $amt;
         elseif($currency=='EUR') return $amt*0.012;
       }

       public  function getSymbol(){
         $currency=session()->get('currency');
         if($currency=='USD') return "$";
         elseif($currency=='INR') return "Rs ";
         elseif($currency=='EUR') return "€ ";
       }

       public function Sess(){  return session()->all(); }

    public function razorPaySuccess(Request $Request)
    {
        $validator = Validator::make($Request->all(), [
            'email'=>'required',
            'first_name'=>'required',
            'last_name'=>'required',
            'state'=>'required',
            'city'=>'required',
            'address'=>'required',
            'zipcode'=>'required',
            'sub_total'=>'required',
            'delivery_charges'=>'required',
            'discount'=>'required',
            'total_amount'=>'required',
            'mobile_no'=>'required',
            'email'=>'required',
        ]);
        if ($validator->fails())
        {
            return response()->json([
             'status' => false,
             'errors' => $validator->errors()
             ]);
        }

        Billing::insertgetId([
            'user_id'=>$Request->session()->get('LOGGED_ID'),
            'first_name'=>$Request->post('first_name'),
            'last_name'=>$Request->post('last_name'),
            'state'=>$Request->post('state'),
            'city'=>$Request->post('city'),
            'address'=>$Request->post('address'),
            'zipcode'=>$Request->post('zipcode'),
            'pay_type'=>$Request->post('pay_type'),
            'sub_total'=>$Request->post('sub_total'),
            'delivery_charges'=>$Request->post('delivery_charges'),
            'discount'=>$Request->post('discount'),
            'total_amount'=>$Request->post('total_amount')+$Request->post('delivery_charges')+$Request->post('discount'),
            'mobile_no'=>$Request->post('mobile_no'),
            'email'=>$Request->post('email'),
            'status'=>'order recieved',
            'created_at'=>date('Y-m-d h:s:i')
        ]);

        $lastId=DB::table('order_details')->insertgetId([
            'user_id'=>$Request->session()->get('LOGGED_ID'),
            'order_id'=>'orderid',
            'payment_id'=>$Request->post('payment_id'),
            'status'=>'order recieved',
            'currency_type'=>$Request->session()->get('currency'),
            'total_amount'=>$Request->post('total_amount')+$Request->post('delivery_charges')+$Request->post('discount'),
            'created_at'=>date('Y-m-d h:s:i')
        ]);

        DB::table('order_details')->where(['id'=>$lastId])->update(['order_id'=>'ORDER'.$lastId]);
        foreach(Cart::getContent() as $product){
            //echo $product->quantity*$product->price."<br />";
            DB::table('order_products')->insertgetId([
                'order_id'=>'ORDER'.$lastId,
                'product_id'=>$product->id,
                'product_name'=>$product->name,
                'price'=>$this->currencySet($product->price),
                'total_price'=>$this->currencySet($product->quantity*$product->price),
                'quantity'=>$product->quantity,
                'created_at'=>date('Y-m-d h:s:i')
            ]);
         }
         
        Cart::clear();
         
         
        return response()->json(['message'=>'Order Place Successfully']);
    }
}
