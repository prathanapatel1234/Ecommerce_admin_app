<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pincode extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	 protected $table = 'pincode';
    protected $fillable = ['pincode'];
}
