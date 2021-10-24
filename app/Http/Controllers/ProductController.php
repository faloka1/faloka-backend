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
            $category = Category::where('slug', '=', $category)->get();
        }
        if($request->has('subcategory')){
            $product->whereHas('sub_categories', function($subcategories) use($subcategory) {
                $subcategories->where('slug', '=', $subcategory);
            });
        }
        return response()->json([
            "category" => $category,
            "product" => $product->get(),
            "count" => $product->get()->count()
        ]);
    }
    public function getproducts($slug){
        $product = Product::with('sub_categories','categories','brands','variants.variants_image')
                    ->where('slug',$slug)->first();
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        } else {
            return response()->json($product);
        }
        

    }
    public function getproductsrelated($productslug){
        $category = Category::whereHas('products', function($q) use ($productslug) {
            $q->where('slug',$productslug);
        })->select('slug')->get()->toArray();
        $product = Product::with('brands','variants.variants_image')
                    ->whereHas('categories',function($q) use ($category){
                        $q->whereIn('slug',$category);
                    })->where('slug','!=',$productslug)->get();
        return response()->json($product);
    }
    public function getMixAndMatch($slug){
        $product = Product::select('slug','mix_and_match_image')
                    ->whereHas('categories',function($q) use ($slug){
                            $q->where('slug',$slug);
                    })->get();
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        } else {
            return response()->json($product);
        }
    }
}
