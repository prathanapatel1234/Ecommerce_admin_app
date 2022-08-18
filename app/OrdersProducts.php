<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdersProducts extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'order_products';
    protected $fillable = ['order_id','product_id','product_name','price','quantity'];

}
