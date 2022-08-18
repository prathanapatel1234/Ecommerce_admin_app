<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'billing_details';
    protected $fillable = ['title'];

}
