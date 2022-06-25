<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientsController extends Controller
{
    function viewGetIn()
    {
        return view('client.get-in');
    }
    function viewRegister()
    {
        return view('client.register');
    }
}
