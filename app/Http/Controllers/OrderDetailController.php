<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OrderDetail;

class OrderDetailController extends Controller
{
    public function store(int $quantity,int $order_id,
            int $shipping_price,string $expedition_name,string $service,
            int $variant_id,int $product_id
            ){
        $orderDetail = new OrderDetail();
        $orderDetail->quantity = $quantity;
        $orderDetail->order_id = $order_id;
        $orderDetail->shipping_price = $shipping_price;
        $orderDetail->expedition_name = $expedition_name;
        $orderDetail->service = $service;
        $orderDetail->variant_id = $variant_id;
        $orderDetail->product_id = $product_id;
        if ($orderDetail->save()){
            return response()->json([ 'message' => "Data Successfully Added"]);
        }
    }
}
