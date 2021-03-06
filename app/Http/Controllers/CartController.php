<?php

namespace App\Http\Controllers;

use App\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!Auth::User()) {
            return response()->json([
                "error" => "User No Found"
            ],401);
        }
        $carts = Cart::with(['products.brands'])->where('user_id',Auth::user()->id)->get();
        foreach ($carts as $cart) {
            $cart->load(['variants.variants_sizes' => function ($query) use ($cart) {
                $query->where('id', $cart->variantsize_id);
            },'variants.variants_image']);
        }
        return response()->json($carts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cart = new Cart();
        $cart->quantity = $request->quantity;
        $cart->variant_id = $request->variant_id;
        $cart->product_id = $request->product_id;
        $cart->variantsize_id = $request->variantsize_id;
        if(!Auth::User()) {
            return response()->json([
                "error" => "User No Found"
            ],401);
        }
        $cart->user_id = Auth::User()->id;
        if($cart->save()){
            return response()->json([
                "message" => "Data Successfully Added",
                'cart_id' => $cart->id
            ]);
        } else {
            return response()->json([ 'message' => "Failed"]);
        }  
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $cart = Cart::findOrFail($id);
        } catch(\Exception $e){
            return response()->json(["Error" => "Cart Not Found"]);
        }
        $cart->quantity = $request->quantity;
        $result = $cart->save();
        if($result){
            return response()->json(['message' => "Quantity Successfully Updated"], 200);
        } else {
            return response()->json(['message' => "Quantity was not Updated, Try Again!"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $cart = Cart::findOrFail($id);
        } catch(\Exception $e){
            return response()->json(["Error" => "Cart Not Found"]);
        }
        $result = $cart->delete();
        if($result){
            return response()->json(['message' => "Data Cart Successfully Deleted"]);
        } else {
            return response()->json(['message' => "Cart was not Deleted, Try Again!"]);
        }
    }
    public function destroybyuser(){
        if(!Auth::User()) {
            return response()->json([
                "error" => "User No Found"
            ]);
        }
        $userID = Auth::user()->id;
        try {
            $cart = Cart::where('user_id',$userID);
        } catch(\Exception $e){
            return response()->json(["Error" => "Cart Not Found"]);
        }
        $result = $cart->delete();
        if($result){
            return response()->json(['message' => "Data Cart Successfully Deleted"]);
        } else {
            return response()->json(['message' => "Cart was not Deleted, Try Again!"]);
        }
    }
}
