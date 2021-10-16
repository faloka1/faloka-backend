<?php

namespace App\Http\Controllers;

use App\Address;
use Illuminate\Http\Request;
use DB;
use App\User;
use App\Province;

class AddressController extends Controller
{
    public function index()
    {
        return response()->json(User::with('addresses.districts','addresses.provinces')->find(auth()->user())->first());
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $address = new Address;
        $address->province_id = $request->province_id;
        $address->district_id = $request->district_id;
        $address->sub_district = $request->sub_district;
        $address->postal_code = $request->postal_code;
        $address->location = $request->location;

        if ($address->save()) {
            $address->users()->attach($user);
            return response()->json([
                'message' => 'Data Address Successfully Added',
                'addresses' => Address::with('districts','provinces')->find($address->id)
            ], 201);
        }
    }

    public function show(Address $address)
    {
        
    }

    public function update(Request $request, $addressId)
    {
        $address = Address::find($addressId);
        if ($request->province_id != null)
            $address->province_id = $request->province_id;

        if ($request->district_id != null)
            $address->district_id = $request->district_id;
    
        if ($request->sub_district != null)
            $address->sub_district = $request->sub_district;

        if ($request->postal_code != null)
            $address->postal_code = $request->postal_code;

        if ($request->location != null)
            $address->location = $request->location;

        if ($address->save()) {
            return response()->json([
                'message' => 'Data Successfully Updated',
                'addresses' => Address::with('districts','provinces')->find($addressId)
            ], 201);
        }
         
    }

    public function destroy($addressId)
    {
        $address = Address::find($addressId);
        $address->users()->detach();
        if ($address->delete()) {
            return response()->json(['message' => "Data Successfully Deleted"]);
        }
    }
    public function getprovince(Request $request){
        DB::statement(DB::raw("SET @row = '-1'"));
        if($request->has('id')){
            $record = DB::table('provinces')
            ->select(
                "provinces.*",
                DB::raw("@row:=@row+1 AS row")
                )->where('province_id', $request->id)->first();
        } else {
            $record = DB::table('provinces')
            ->select(
                "provinces.*",
                DB::raw("@row:=@row+1 AS row")
                )->get();
        }
        
        return response()->json($record);
    }
    public function getdistrict(Request $request){
        DB::statement(DB::raw("SET @row = '-1'"));
        if($request->has('province')){
            $record = DB::table('districts')
            ->select(
                "districts.*",
                DB::raw("@row:=@row+1 AS row")
                )->where('province_id', $request->province)->get();
        } else {
            $record = DB::table('districts')
            ->select(
                "districts.*",
                DB::raw("@row:=@row+1 AS row")
                )->get();
        }
        return response()->json($record);
    }
    public function get_ongkir(Request $request){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "origin=".$request->origin."&destination=".$request->destination."&weight=".$request->weight."&courier=".$request->courier,
        CURLOPT_HTTPHEADER => array(
            "content-type: application/x-www-form-urlencoded",
            "key: e5db299c04fb4d8973493378607f48ef"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        echo "cURL Error #:" . $err;
        } else {
            $response=json_decode($response,true);
            $data_ongkir = $response['rajaongkir']['results'];
            return response()->json($data_ongkir);
        }
    }
}
