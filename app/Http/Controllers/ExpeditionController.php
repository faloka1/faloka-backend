<?php

namespace App\Http\Controllers;

use App\Expedition;
use Illuminate\Http\Request;

class ExpeditionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Expedition::get());
    }
}
