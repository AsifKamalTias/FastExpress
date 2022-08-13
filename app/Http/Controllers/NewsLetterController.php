<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Newslettersubscriber;
use Illuminate\Support\Facades\Validator;

class NewsLetterController extends Controller
{
    function viewNotFound()
    {
        return abort(404);
    }

    function addEmail(Request $req)
    {
        $this->validate($req, [
            'sub_email' => 'required|email'
        ],
        [
            'sub_email.required' => 'Email is required.',
            'sub_email.email' => 'Enter a valide email'
        ]
    );
        $subscriber = new Newslettersubscriber();
        $subscriber->subscriber_email = $req->sub_email;
        $subscriber->save();
        session()->flash('success', "Thanks for subscribe!");
        return redirect()->route('home');
    }

    function addEmailResponse(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'email' => 'required|email'
        ],
        [
            'email.required' => 'Email is required.',
            'email.email' => 'Enter a valid email'
        ]        
    );
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $subscriber = new Newslettersubscriber();
        $subscriber->subscriber_email = $req->email;
        $subscriber->save();
        return response()->json(['success'=>'Thanks for subscribe!'], 200) ;
    }


}
