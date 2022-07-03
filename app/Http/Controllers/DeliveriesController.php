<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeliveriesController extends Controller
{
    function viewDeliveryStart()
    {
        return view('deliveries.start');
    }
}
