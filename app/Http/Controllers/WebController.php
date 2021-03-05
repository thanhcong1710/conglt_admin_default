<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebController extends Controller
{
    public function index(Request $request){
        return view( 'frontend.index');
    }
    public function register(Request $request){
        return view( 'frontend.register');
    }
}
