<?php

namespace App\Http\Controllers;

use App\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cart = Cart::with(
            'variants',
            'products.brands');
        if(!Auth::User()) {
            return response()->json([
                "error" => "User No Found"
            ]);
        }
        $cart->where('user_id',Auth::user()->id);
        return response()->json($cart->get());
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
        if(!Auth::User()) {
            return response()->json([
                "error" => "User No Found"
            ]);
        }
        // return response()->json([
        //     "error" => "Bener"
        // ]);
        $cart->user_id = Auth::User()->id;
        if($cart->save()){
            return response()->json([
                "massage" => "Data Successfully Added"
            ]);
        } else {
            return response()->json([ 'message' => "Failed"]);
        }  
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        //
    }
}
