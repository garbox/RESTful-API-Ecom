<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JsonForm extends Controller
{

    public function index(){
        return view('json-form');
    }
}
