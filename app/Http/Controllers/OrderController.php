<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Order;
use Storage;
use Response;

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
                $request->quantity,$order->id,$request->variant_id,$request->product_id
            );
            return Response::json(array('message' => "Data Successfully Added", 'order_id' => $order->id), 200);
        }else {
            return response()->json([ 'message' => "Failed"]);
        }       
    }
    public function uploadImage(Request $request,$id){
        $validator = Validator::make($request->all(), [
            'image' => 'required|image:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error', 'message'=> $validator->messages()->first(),$request->all()
            ], 500);
        }
        $uploadFolder = 'payments';
        $image = $request->file('image');
        $image_uploaded_path = $image->store($uploadFolder, 'public');
        $order = Order::where("id",$id)->update([
            'image_payment_url' => '/storage/' . $image_uploaded_path,
            'status' => "dikirim"
        ]);
        if ($order){
            return response()->json(['message' => "Data Successfully Updated"]);
        } else {
            return response()->json(['message' => "Failed"]);
        }
    }
    public function getorder(Request $request){
        $status = $request->status;
        $order = Order::with(
            'order_details.variants.variants_image',
            'order_details.products.brands',
            'address.districts','address.provinces',
            'payment')->where('user_id',Auth::user()->id);
        if($request->has('status')){
            $order->where('status', '=', $status);
        }
        
        return response()->json($order->get());
    }
}
