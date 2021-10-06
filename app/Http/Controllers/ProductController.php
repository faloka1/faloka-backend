<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
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
        //
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
    public function getproductsrelated($productslug){
        $category = Category::whereHas('products', function($q) use ($productslug) {
            $q->where('slug',$productslug);
        })->select('slug')->get()->toArray();

        // $product = Category::with(['products' => function($q) use ($productslug){
        //     $q->where('products.slug','!=',$productslug);
        // }])->whereIn('slug',$category)->get();
        $product = Product::with('brands','variants.variants_image')
                    ->whereHas('categories',function($q) use ($category){
                        $q->whereIn('slug',$category);
                    })->where('slug','!=',$productslug)->get();
        // $product = Product::with('sub_categories','categories','brands','variants.variants_image')
        //            ->whereIn('categories', function($q) use ($category) {
        //                 $q->whereIn('slug', $category);
        //             })->where('slug', '!=', $productslug);
        // $array = json_decode(json_encode($category), true);
        return $product;

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
