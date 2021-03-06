<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use App\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function allProduct(Request $request)
    {
        $category = $request->category;
        $subcategory = $request->subcategory;
        $product = Product::with('sub_categories','categories','brands','variants.variants_image','variants.variants_sizes');
        if($request->has('category')){
            $product->whereHas('categories', function($categories) use($category) {
                $categories->where('slug', '=', $category);
            })->get();
            $category = Category::where('slug', '=', $category)->get();
        }
        if($request->has('subcategory')){
            $product->whereHas('sub_categories', function($subcategories) use($subcategory) {
                $subcategories->where('slug', '=', $subcategory);
            })->get();
            $subcategory = SubCategory::with('category')->where('slug', '=', $subcategory)->get();
        }
        if($request->has('search')){
            if($request->search == ""){
                return response()->json([
                    "category" => $category,
                    "sub_category" => $subcategory,
                    "products" => [],
                    "count" => 0
                ]);
            }
            $product->where('name', 'like', '%' . $request->search . '%');
        }
        return response()->json([
            "category" => $category,
            "sub_category" => $subcategory,
            "products" => $product->get(),
            "count" => $product->get()->count()
        ]);
    }
    public function getproducts($slug){
        $product = Product::with('sub_categories','categories','brands','variants.variants_image','variants.variants_sizes')
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
        $product = Product::with('brands','variants.variants_image','variants.variants_sizes')
                    ->whereHas('categories',function($q) use ($category){
                        $q->whereIn('slug',$category);
                    })->where('slug','!=',$productslug)->limit(4)->get();
        return response()->json($product);
    }
    public function getMixAndMatch(Request $request){
        $category = $request->category;
        $product = DB::table('products as p')->select(
            'p.id',
            'p.slug',
            'p.mix_and_match_image',
            'vi.image_url'
        )
        ->leftjoin('variants as v','p.id','=','v.product_id')
        ->leftjoin('variant_images as vi','vi.variant_id','=','v.id')
        ->leftjoin('category_product as cp','p.id','=','cp.product_id')
        ->leftjoin('categories as c','c.id','=','cp.category_id');
        
        if($request->has('category')){
            $product->where('c.slug',$category);
        }
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        } else {
            return response()->json($product->distinct()->get());
        }
    }
    public function cartrelated(){
        $product = Product::with('sub_categories','categories','brands','variants.variants_image','variants.variants_sizes')
                    ->inRandomOrder()
                    ->limit(5);
        return response()->json($product->get());
    }
}
