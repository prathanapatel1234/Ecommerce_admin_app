<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Chart;
use DB;
class ChartController extends Controller
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function index()
    {
        $users = DB::table('countries')->select('name')->get();
        return view('chart', compact('users'));
    }

}
