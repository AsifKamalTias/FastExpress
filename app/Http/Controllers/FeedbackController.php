<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;

class FeedbackController extends Controller
{
    function viewFeedback()
    {
        return view('feedback');
    }

    function postFeedBack(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'message' => 'required'
        ]);

        $feedback = new Feedback();
        $feedback->fb_tittle = $request->title;
        $feedback->fb_messege = $request->message;
        $feedback->save();

        Session()->flash('success', 'Your feedback has been sent successfully.');

        return redirect()->route('feedback');
    }
    
}
