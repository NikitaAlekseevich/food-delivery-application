<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\Products;
use App\Models\User;
use Illuminate\Http\Request;

class OrderManager extends Controller
{
    function newOrders(){
        $orders = Orders::where("status", "open")->get();
        $orders = json_decode(json_encode($orders));
        $delivery_boys = User::where("type", "delivery")->get();
        $products = Products::get();
        foreach($orders as $key => $order){
            $order_item_ids = json_decode($order->items);
            foreach($order_item_ids as $key2 => $order_item){
                foreach($products as $product){
                    if($order_item -> item_id == $product->id){
                        $orders[$key]->item_details[$key2] = $product;
                    }
                }
            }
        }
        return view("dashboard", compact("orders", "delivery_boys"));
    }
    function assignOrder(Request $request){
        $order = Orders::where("id", $request->order_id)->first();
        $order->delivery_boy_email = $request->delivery_boy_email;
        $order->status = "assigned";
        if($order->save()){
            return redirect(route("dashboard"))
            ->with("success", "Order assigned successfully");
        }
        return redirect(route("dashboard"))
            ->with("error", "Failed to assign Order");
    }

    function listOrders(){
        $orders = Orders::orderBy("id", "DESC")->get();
        $orders = json_decode(json_encode($orders));
        $products = Products::get();
        foreach($orders as $key => $order){
            $order_item_ids = json_decode($order->items);
            foreach($order_item_ids as $key2 => $order_item){
                foreach($products as $product){
                    if($order_item -> item_id == $product->id){
                        $orders[$key]->item_details[$key2] = $product;
                    }
                }
            }
        }
        return view("order", compact("orders"));
    }
}
