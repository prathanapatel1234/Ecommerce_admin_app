<?php

namespace App\Http\Controllers\Frontend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Cart;
use App\Product;
use App\ProductsVariations;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $product = Product::find($request->id);
        $productprice = ProductsVariations::where(['product_id'=>$product->id])->first();
        
        
        $data= Cart::add($product->id,$request->prdimage,$product->short_desc,$product->product_name, $request->mrpprice, 1, $request->mrpprice);
        if($request->ajax()) return response()->json(['success'=>'true','data'=>"$product->product_name has successfully beed added to the shopping cart!"]);
        else                 return back()->with('success',"$product->product_name has successfully being added to the shopping cart!");
    }

    public function cart(){
        $params = ['title' => 'Shopping Cart Checkout'];
        return view('front.cart')->with($params);
    }

    public function checkout(){
        return view('front.checkout');
    }

    public function clear(){
        Cart::clear();
        return back()->with('success',"The shopping cart has successfully beed added to the shopping cart!");;
    }
    public function remove(Request $request){
        Cart::remove($request->id);
        return back()->with('success', 'Item is removed!');
    }

    public function update(Request $request){
        $quantity=$request->post('quantity');
            foreach($quantity as $qkey=>$qdata){
                foreach($qdata as $key=>$val ){
                    Cart::update($qkey,
                        array(
                            'quantity' => array(
                                'relative' => false,
                                'value' => $val
                            ),
                    ));
                }
            }
        return back()->with('success', 'Cart is Updated!');
    }
}
