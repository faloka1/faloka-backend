<?php

namespace App\Http\Controllers;

use App\Address;
use Illuminate\Http\Request;
use App\User;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(User::with('addresses')->find(auth()->user()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $address = new Address;
        $address->name = $request->name;
        $address->phone_number = $request->phone_number;
        $address->province = $request->province;
        $address->district = $request->district;
        $address->sub_district = $request->sub_district;
        $address->postal_code = $request->postal_code;
        $address->location = $request->location;


        if ($address->save()) {
            $address->users()->attach($user);
            return response()->json(['message' => "Data Address Successfully Added"]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function show(Address $address)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $addressId)
    {
        $address = Address::find($addressId);
        if ($request->name != null)
            $address->name = $request->name;

        if ($request->phone_number != null)
            $address->phone_number = $request->phone_number;
        
        if ($request->province != null)
            $address->province = $request->province;

        if ($request->district != null)
            $address->district = $request->district;

        if ($request->sub_district != null)
            $address->sub_district = $request->sub_district;

        if ($request->postal_code != null)
            $address->postal_code = $request->postal_code;

        if ($request->location != null)
            $address->location = $request->location;

        if ($address->save()) {
            return response()->json([ 'message' => "Data Successfully Updated"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function destroy($addressId)
    {
        $address = Address::find($addressId);
        $address->users()->detach();
        if ($address->delete()) {
            return response()->json(['message' => "Data Successfully Deleted"]);
        }
    }
}
