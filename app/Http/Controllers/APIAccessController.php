<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class APIAccessController extends Controller
{
    public function index(){
        return view('admin.apiaccess.index');
    }
}
