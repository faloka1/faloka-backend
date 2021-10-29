<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Http\Request;
use App\User;

class JWTAuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|between:2,100',
            'gender' => 'in:L,P',
            'email' => 'required|email|unique:users|max:50',
            'phone_number' => 'required|numeric|min:7',
            'password' => 'required|confirmed|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "error" => $validator->errors()
            ], 422);            
        }

        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));
        if(!$user){
            return response()->json([
                'message' => 'Something went wrong',
            ], 500); 
        }
        return response()->json([
            'message' => 'Successfully registered',
            'user' => $user
        ], 201);
    }

    public function login(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (! $token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->createNewToken($token);
    }

    public function profile()
    {
        return response()->json(User::with('adresses')->find(auth()->user()));
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
