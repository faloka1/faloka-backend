<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Product;

class VisualSearchController extends Controller
{
    
    public function getvisualsearch(){
        $client = new \GuzzleHttp\Client();
        $request = $client->get(env('VISUALSEARCH_URL') . 'list');
        $response = $request->getBody()->getContents();
        return response()->json(json_decode($response));
    }

    public function postvisualsearch(Request $request){
        
        $file               = request('img');
        $file_path          = $file->getPathname();
        $file_mime          = $file->getMimeType('image');
        $file_uploaded_name = $file->getClientOriginalName();
        $product_id = $request->input('product_id');
        $client = new \GuzzleHttp\Client();

        $response = $client->request('POST', env('VISUALSEARCH_URL') . 'insert', [
            'multipart' => [
                [
                    'name'     => 'img',
                    'contents' => fopen($file_path, 'r')
                ],
                [
                    'name'     => 'product_id',
                    'contents' => $product_id
                ]
            ]
        ]);
       echo $response->getBody()->getContents();
    }
    public function search(Request $request){
        
        $file               = request('img');
        $file_path          = $file->getPathname();
        $file_mime          = $file->getMimeType('image');
        $file_uploaded_name = $file->getClientOriginalName();

        $client = new \GuzzleHttp\Client();
        try {
            $response = $client->request('POST', env('VISUALSEARCH_URL') . 'search', [
                'multipart' => [
                    [
                        'name'     => 'img',
                        'contents' => fopen($file_path, 'r')
                    ]
                ]
            ]);
            $data = json_decode($response->getBody(), true);
            $product = Product::with('sub_categories','categories','brands','variants.variants_image')
                    ->whereIn('id',$data)
                    ->orderByRaw(\DB::raw("FIELD(id, ".implode(",",$data).")"))
                    ->get();
            return response()->json($product);
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            return $e->getResponse()->getBody()->getContents();
        }
    }
}
