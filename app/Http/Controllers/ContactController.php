<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

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
}
