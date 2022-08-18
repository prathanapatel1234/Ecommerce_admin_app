<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = ['product_name','slug','category_id','category_name','sub_category_id','sub_category_name','latest','total_qty','mrp_price','selling_price','price','short_desc','location','status','image'];

    public function products_variations()
    {
       return $this->hasMany('App\ProductsVariations', 'product_id','id');
    }
    public function prices()
    {
         return $this->hasOne('App\ProductsVariations', 'product_id','id');
    }
}
