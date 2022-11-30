<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class AlurController extends Controller
{
    public function index(){
        return view('frontend.alur');
    }
}
