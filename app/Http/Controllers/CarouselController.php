<?php

namespace App\Http\Controllers;

use App\Carausel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CarouselController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carousels = DB::table('carousels')->get();
        return response()->json(['carousels' => $carousels]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'image' => 'required|image:jpeg,png,jpg,gif,svg|max:2048'
    //     ]);

    //     if ($validator->fails()) {
    //         return sendCustomResponse($validator->messages()->first(),  'error', 500);
    //     }
    //     $category = App\Category::find(1);
    //     $uploadFolder = 'carousels';
    //     $image = $request->file('image');
    //     $image_uploaded_path = $image->store($uploadFolder, 'public');
    //     $carousel = new App\Carousel(['image' => Storage::disk('public')->url($image_uploaded_path)]);

    //     $category->carousels()->save($carousel);
    // }

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
}
