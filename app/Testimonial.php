<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'testimonial';
    protected $fillable = ['heading','title'];

}
