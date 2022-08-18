<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contribution extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	 protected $table = 'contribution';
    protected $fillable = ['TransactionID','PromoterId','Amount','fundraiser_code','contribution_status'];
}
