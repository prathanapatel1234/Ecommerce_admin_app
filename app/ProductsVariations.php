<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductsVariations extends Model
{
    protected $table = 'product_variation';
    protected $fillable = ['product_id','product_weight','product_mrp_price','product_sell_price','product_total_qty','product_image'];
}
