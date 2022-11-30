<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class KurikulumController extends Controller
{
    public function index(){
        return view('frontend.kurikulum');
    }

}
