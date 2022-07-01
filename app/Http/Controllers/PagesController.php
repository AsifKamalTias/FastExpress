<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    function viewHome()
    {
        return view('home');
    }

    function viewAbout()
    {
        return view('about');
    }
    
    function viewTermsAndConditions()
    {
        return view('terms-and-conditions');
    }
}
