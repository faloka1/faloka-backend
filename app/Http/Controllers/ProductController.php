<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$categories = $request->query('category');
        //$categories = request()->fullUrlWithQuery([['category' => 'cewek']]);
        $subcategories = Input::get('subcategory');
        // $product = Product::with(['sub_categories' => function ($query) {
        //     $query->where('slug', '=', 'kaos');
        // }])->get();
        
        //$product = Product::with('sub_categories')->get();
        return response()->json($product);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }
    public function allProduct(Request $request)
    {
        $category = $request->category;
        $subcategory = $request->subcategory;
        $product = Product::with('sub_categories','categories','brands','variants.variants_image');
        if($request->has('category')){
            $product->whereHas('categories', function($categories) use($category) {
                $categories->where('slug', '=', $category);
            });
        }
        if($request->has('subcategory')){
            $product->whereHas('sub_categories', function($subcategories) use($subcategory) {
                $subcategories->where('slug', '=', $subcategory);
            });
        }
        return response()->json($product->get());
    }
    public function getproducts($slug){
        $product = Product::with('sub_categories','categories','brands','variants.variants_image')
                    ->where('slug',$slug);
        return response()->json($product->first());

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
