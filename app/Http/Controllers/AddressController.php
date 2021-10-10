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

    protected $fillable = [
        'name','phone_number','province',
        'district','sub_district','postal_code',
        'location'
    ];

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
    public function update(Request $request, Address $address)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function destroy(Address $address)
    {
        $address->users()->detach($user);
    }
}
