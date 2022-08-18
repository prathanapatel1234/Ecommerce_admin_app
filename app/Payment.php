<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'payment_details';
    protected $fillable = ['title'];

}
