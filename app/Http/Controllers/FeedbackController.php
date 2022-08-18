<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use Illuminate\Support\Facades\Validator;

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

    function postFeedBackResponse(Request $request)
    {
        // return response()->json(['message'=>'Thanks for your feedback!'], 200) ;
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'message' => 'required'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
        $feedback = new Feedback();
        $feedback->fb_tittle = $request->title;
        $feedback->fb_messege = $request->message;
        $feedback->save();
        return response()->json(['message'=>'Thanks for your feedback!'], 200) ;
    }
    
}
