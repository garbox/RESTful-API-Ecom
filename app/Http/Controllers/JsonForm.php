<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use App\Models\ApiToken;

class JsonForm extends Controller
{

    public function index(){
        $appToken = ApiToken::first();
        $AdminToken = Admin::first();;
        $userToken = User::first();;

        return view('json-form', ['appToken' => $appToken, 'adminToken' => $AdminToken, "userToken" => $userToken]);
    }
}
