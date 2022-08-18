<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	 protected $table = 'transactions';
    protected $fillable = ['user_id', 'order_id', 'trans_type ','amount'];
}
