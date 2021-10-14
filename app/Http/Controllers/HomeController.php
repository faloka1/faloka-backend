<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $home = Category::with('carousels','sub_categories','products.brands','products.variants.variants_image')
                ->take(-1)
                ->get();
        return response()->json($home);
            
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
    public function showPopuler($slug){
        $user = DB::table('category_sub_category')
                ->join('categories', 'categories.id', '=', 'category_sub_category.category_id')
                ->join('sub_categories', 'category_sub_category.sub_category_id', '=', 'sub_categories.id')
                ->select('sub_categories.name','sub_categories.slug')
                ->where('categories.slug',$slug)
                ->limit(3)
                ->get();
        return response()->json(['sub_categories' => $user]);
    }
}
