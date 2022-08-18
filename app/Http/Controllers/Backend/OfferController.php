<?php
namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pincode;
use App\Offer;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use DataTables;
use Validator;
use Auth;

class OfferController extends Controller
{
    public function index(Request $request)
    {
       $offer = Offer::get();
        return view('admin.offer.offer')->with(['offer'=>$offer]);
    }

    public function getCouponCheck()
    {
       $coup=request('coupon');
       $couponCheck= Offer::getTableDataWhere('offers',$coup);
       return response()->json($couponCheck);
    }


    public function getAllStoresInOffer() { $stores= Offer::getTableData('offers'); return response()->json($stores); }

    public function create()
    {
        return view('admin.offer.offer-create');
    }

    public function CouponUserSave(Request $request)
     {
          $couponlen=DB::table('offer_validate')->where(['user_id'=>$request->post('user_id'),'store_id'=>$request->post('store_id'),'coupon_code'=>$request->post('coupon_code_offer')])->count();
          $coupon_data=DB::table('offers')->select('coupon_uses','no_users_uses')->where(['offer_type_amt_code'=>$request->post('coupon_code_offer')])->get();
          $coupon_uses=$coupon_data[0]->coupon_uses;
          $no_users_uses=$coupon_data[0]->no_users_uses;

          if($couponlen<$coupon_uses){
               $data=DB::table('coupon_users')->where(['mobile'=>$request->post('mobile')])->get();

            //     print_r($data[0]->mobile);
            //   exit;
              if(count($data)==0)
              {
                  $coupon_user_id=Offer::CouponUserSave();
                  return response()->json(['status' => true,'message' => 'Offer Validate']);
              }
               else
               {
                       $coupon_users_id=$data[0]->id;
                       if($couponlen<$no_users_uses)
                        {
                             $offerstatus='success';
                             $message='Offer Validate';
                             $status='true';
                        }
                        else
                        {
                             $offerstatus='unsuccess';
                             $message='Coupon Code Already Used';
                             $status='false';
                        }
                        DB::table('offer_validate')->insertGetId([
                            'user_id' => request('user_id'),
                            'coupon_user_id'=>$coupon_users_id,
                            'store_id' => request('store_id'),
                            'offer_amt' => request('offer_amt'),
                            'coupon_code' => request('coupon_code_offer'),
                            'discount_amt' => request('discount_amt_offer'),
                            'total_pay_amt' => request('total_amt_pay'),
                            'mobile_no'=>$data[0]->mobile,
                            'status' =>$offerstatus,
                            'created_at'=>date('Y-m-d h:s:i'),
                        ]);
                     return response()->json(['status' => $status,'message' =>$message]);
               }
             }
             else     return response()->json(['status' => false,'message' =>'Offer is Expired']);
    }


    public function edit($id){
      $offer =  Offer::find($id);
       return view('admin.offer.offer-create')->with(['offer'=>$offer]);
    }

    public function store(Request $request)
    {
        // print_r($request->file());
        // exit;
        $validator = Validator::make($request->all(), [
            'offer_name' => 'required',
            'coupon_type'=> 'required',
            'coupon_uses'=> 'required',
            'receipt_amt'=>'required'
        ]);

        if($validator->fails())
        {
		   return response()->json(['status' => false,'errors' => $validator->errors()]);
        }
        else
        {
            Offer::store();
            return response()->json(['status' => true,'msg' => 'Offers created successfully']);
        }
    }

    public function update(Request $request,$id){
       $offer = Offer::find($id);
       $offer->offer_name=$request->offer_name;
       $offer->coupon_type=$request->coupon_type;
       $offer->offer_desc=$request->offer_desc;
       $offer->discount_amountoff=$request->discount_amountoff;
       $offer->discount_percentage=$request->discount_percentage;
       $offer->coupon_uses=$request->coupon_uses;
       $offer->receipt_amt=$request->receipt_amt;
       $offer->updated_at=date('Y-m-d h:i:s');
       $offer->save();

       return response()->json(['status' => true,'msg' => 'Offers Updated successfully']);
    }

}
