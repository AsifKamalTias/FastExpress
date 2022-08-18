<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    function viewContact()
    {
        return view('contact');
    }

    function postContact(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        $contact = new Contact();
        $contact->contact_name = $request->name;
        $contact->contact_email = $request->email;
        $contact->contact_message = $request->message;
        $contact->save();

        Session()->flash('success', 'Your message has been sent successfully. We will get back to you soon.');
        
        return redirect()->route('contact');
    }

    function postContactResponse(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
        
        $contact = new Contact();
        $contact->contact_name = $request->name;
        $contact->contact_email = $request->email;
        $contact->contact_message = $request->message;
        $contact->save();
        
        return response()->json(['message'=>'Thanks for contacting us!'], 200) ;
    }
}
