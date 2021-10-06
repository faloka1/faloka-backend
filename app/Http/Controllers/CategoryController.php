<?php

namespace App\Http\Controllers;

use App\Category;
use App\Carousel;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Storage;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        
        $validator = Validator::make($data, [
            'name' => 'required|between:2,100',
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $category = Category::create($data);

        return response()->json([
            'message' => 'Successfully Add Category',
            'user' => $category
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }
    public function addcarousel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($validator->fails()) {
            return sendCustomResponse($validator->messages()->first(),  'error', 500);
        }
        $category = Category::find($request->input('id'));
        $uploadFolder = 'carousels';
        $image = $request->file('image');
        $image_uploaded_path = $image->store($uploadFolder, 'public');
        $carousel = new Carousel(['image' => '/storage/' . $image_uploaded_path]);

        return response()->json([
            'message' => 'Successfully Add Carousel',
            'carousels' => $category->carousels()->save($carousel)
        ], 201); 
    }
}
