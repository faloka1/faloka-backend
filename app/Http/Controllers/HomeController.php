<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $home = Category::with('carousels','sub_categories','products.brands','products.variants.variants_image')
                ->take(-1)
                ->get();
        return response()->json($home);
            
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
