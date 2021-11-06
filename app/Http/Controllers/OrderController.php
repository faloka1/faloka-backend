<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Order;
use App\OrderDetail;
use App\Shipping;
use App\OrderBrand;
use Storage;
use Response;

use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $order = new Order();
        $order->payment_id = $request->payment_id;
        $order->user_id = Auth::User()->id;
        $order->address_id = $request->address_id;
        if ($order->save()){
            $datas = $request->order_brands;
            foreach($datas as $data){
                $shipping = new Shipping();
                $shipping->shipping_price = $data['shipping_price'];
                $shipping->expedition_name = $data['expedition_name'];
                $shipping->service = $data['service'];
                $shipping->save();
                $brand = new OrderBrand();
                $brand->order_id = $order->id;
                $brand->brand_id = $data['brand_id'];;
                $brand->shipping_id = $shipping->id;
                $brand->save();
                $items = $data['items'];
                foreach($items as $item){
                    $orderDetail = new OrderDetail();
                    $orderDetail->quantity = $item['quantity'];
                    $orderDetail->order_id = $order->id;
                    $orderDetail->order_brand_id = $brand->id;
                    $orderDetail->variant_id = $item['variant_id'];
                    $orderDetail->product_id = $item['product_id'];
                    $orderDetail->save();
                }
            }
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
            'status' => "pending"
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
            'order_brands.shipping',
            'order_brands.order_details',
            'order_brands.order_details.variants.variants_image',
            'order_brands.order_details.products',
            'address.districts','address.provinces',
            'payment')->where('user_id',Auth::user()->id);
        if($request->has('status')){
            $order->where('status', '=', $status);
        }

        return response()->json($order->orderBy('id', 'DESC')->get());
    }
}
