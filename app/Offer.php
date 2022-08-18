<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Auth;
class Offer extends Model
{
    public static function getTableData($table){return DB::table($table)->get();}

    public static function store()
    {
            $id=DB::table('offers')->insertGetId([
                'offer_name' =>request('offer_name'),
                'coupon_type' =>request('coupon_type'),
                'coupon_uses'=>request('coupon_uses'),
                'discount_amountoff' =>request('discount_amountoff'),
                'discount_percentage' =>request('discount_percentage'),
                'receipt_amt' =>request('receipt_amt'),
                'created_at'=>date('Y-m-d H:i:s'),
                'created_by'=>Auth()->user()->id,
            ]);
    }

    protected $table = 'offers';
    protected $fillable = ['user_id'];

    public static function getTableDataWhere($table,$id)
    {
        // echo request('disType');
        // exit;
        $stores=request('stores');
        $day=date('l',strtotime(date('Y-m-d')));
        $month=date('F');
//         exit;
        $whereCon=array();
        if(request('disType')==2)
        {
            $whereCon[]='offer_discount_type=2';
            $whereCon[]="FIND_IN_SET('$day',receipt_day)";
            $whereCon[]="FIND_IN_SET('$month',receipt_month)";
            $whereCon[]="FIND_IN_SET('$stores',stores)";
            $where=implode(' AND ',$whereCon);
            // echo "<pre>";print_r("select * from offers WHERE $where");
            // exit;
             return  $data=DB::select("select * from offers WHERE $where");
        }
        elseif(request('disType')==1)
        {
           $whereCon[]='offer_discount_type=1';
           $whereCon[]="FIND_IN_SET('$day',receipt_day)";
           $whereCon[]="FIND_IN_SET('$month',receipt_month)";
           $whereCon[]="FIND_IN_SET('$stores',stores)";
           $where=implode(' AND ',$whereCon);
        //    echo "<pre>";print_r("select * from offers WHERE $where");
        //     exit;
             return  $data=DB::select("select * from offers WHERE $where");
        }
    }

    public static function CouponUserSave()
    {
       $id=DB::table('coupon_users')->insertGetId([
            'name' => request('name'),
            'email' => request('email'),
            'mobile' => request('mobile'),
            'created_by'=>Auth()->user()->id
        ]);
        $data=DB::table("coupon_users")->where(['id'=>$id])->get();
        DB::table('offer_validate')->insertGetId([
            'user_id' => request('user_id'),
            'coupon_user_id'=>$id,
            'store_id' => request('store_id'),
            'offer_amt' => request('offer_amt'),
            'coupon_code' => request('coupon_code_offer'),
            'discount_amt' => request('discount_amt_offer'),
            'total_pay_amt' => request('total_amt_pay'),
            'mobile_no'=>$data[0]->mobile,
            'status' => 'success',
            'created_at'=>date('Y-m-d h:s:i')
        ]);
    }


    public static function getStoresBusiness($table,$id){ return DB::table('store')->select(['id','store_name'])->where(['business_id'=>$id])->get();}

    public function user_detail()
    {
       return $this->hasOne('App\User', 'id', 'user_id');
    }

	public function created_detail()
    {
       return $this->hasOne('App\User', 'id', 'created_by');
    }

}
