<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FoodOrderController extends Controller
{
    public function list($status){
        return view('food_order.list');
    }
}
