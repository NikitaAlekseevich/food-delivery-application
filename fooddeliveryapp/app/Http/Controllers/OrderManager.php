<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\User;
use Illuminate\Http\Request;

class OrderManager extends Controller
{
    function newOrders(){
        $orders = Orders::where("status", "open")->get();
        $delivery_boys = User::where("type", "delivery")->get();
        return view("dashboard", compact("orders", "delivery_boys"));
    }
}
