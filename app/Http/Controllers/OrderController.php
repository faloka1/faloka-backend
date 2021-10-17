<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;

use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $order = new Order();
        $orderDetailController = new OrderDetailController();
        $order->shipping_price = $request->shipping_price;
        $order->expedition_name = $request->expedition_name;
        $order->service = $request->service;
        $order->payment_id = $request->payment_id;
        $order->user_id = Auth::User()->id;
        $order->address_id = $request->address_id;
        if ($order->save()){
            $orderDetail = $orderDetailController->store(
                $request->quantity,$order->id,$request->variant_id
            );
            return response()->json([ 'message' => "Data Successfully Added"]);
        }else {
            return response()->json([ 'message' => "Failed"]);
        }
        
    }
}
