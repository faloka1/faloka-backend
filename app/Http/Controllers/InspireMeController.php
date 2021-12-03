<?php

namespace App\Http\Controllers;

use App\InspireMe;
use App\InspireMeProduct;
use App\OrderDetail;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;

class InspireMeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inspireMe = InspireMe::with(
            'inspiremeproducts',
            'inspiremeproducts.variants.variants_image',
            'inspiremeproducts.variants.variants_sizes',
            'inspiremeproducts.products.brands',
            'user')->orderBy('id', 'DESC')->paginate(12);
        return response()->json($inspireMe);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'image' => 'required|image:jpeg,png,jpg,gif,svg|max:2048',
            'caption' => 'required'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error', 'message'=> $validator->messages(),$request->all()
            ], 500);
        }
        $uploadFolder = 'inspiremes';
        $image = $request->file('image');
        $image_uploaded_path = $image->store($uploadFolder, 'public');
        $inspireme = new InspireMe([
            'image_url' => '/storage/' . $image_uploaded_path,
            'user_id' => Auth::User()->id,
            'caption' =>  $request->caption
        ]);
        $inspireme->save();
        $products = $request->products;
        foreach($products as $data){
            $inspiremeprod = new InspireMeProduct();
            $inspiremeprod->inspire_me_id = $inspireme->id;
            $inspiremeprod->product_id = $data['product_id'];
            $inspiremeprod->variant_id  = $data['variant_id'];
            $inspiremeprod->save();
        };

        return response()->json([
            'message' => 'Successfully Add Outfit',
            'inpireme_id' => $inspireme->id
        ], 201); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\InspireMe  $inspireMe
     * @return \Illuminate\Http\Response
     */
    public function show(InspireMe $inspireMe)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\InspireMe  $inspireMe
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InspireMe $inspireMe)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\InspireMe  $inspireMe
     * @return \Illuminate\Http\Response
     */
    public function destroy(InspireMe $inspireMe)
    {
        //
    }
    public function getproductuser()
    {
        if(!Auth::User()) {
            return response()->json([
                "error" => "User No Found"
            ],401);
        }
        $orderproduct = OrderDetail::with('variants.variants_image','variants.variants_sizes','products.brands')->whereHas('order', function ($query) {
            return $query->where('user_id', '=', Auth::User()->id);
        })->get();

        return response()->json($orderproduct);
    }
    public function getinspireme($id){
        $inspireMe = InspireMe::with(
            'inspiremeproducts',
            'inspiremeproducts.variants.variants_image',
            'inspiremeproducts.variants.variants_sizes',
            'inspiremeproducts.products','user')->where('id',$id)->get();
        if(count($inspireMe) < 1){
            return response()->json(['error' => 'Inspire Me not found'],404);
        }
        return response()->json($inspireMe);
        
    }
    public function getpost(){
        if(!Auth::User()) {
            return response()->json([
                "error" => "User No Found"
            ],401);
        }
        $inspireMe = InspireMe::with(
            'inspiremeproducts',
            'inspiremeproducts.variants.variants_image',
            'inspiremeproducts.variants.variants_sizes',
            'inspiremeproducts.products',
            'inspiremeproducts.products.brands')->where('user_id',Auth::User()->id)->orderBy('id', 'DESC')->get();
        if(count($inspireMe) < 1){
            return response()->json(['error' => 'Inspire Me not found'],404);
        }
        return response()->json($inspireMe);
    }
}
