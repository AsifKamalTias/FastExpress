<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deliveryman;
class DeliveryMansController extends Controller
{
    //
    function viewRegister()
    {
        return view('deliveryman.register');
    }
    function dmRegister(Request $request)
    {
        
        
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'phone' => 'required|min:11|numeric',
            'email' => 'required|email',
            'nid' => 'digits_between:10,17|required|numeric',
            'dob' => 'nullable|date_format:Y-m-d|before:today',
            'password' => 'required|min:8|regex:/(?=(.*[0-9]))((?=.*[A-Za-z0-9])(?=.*[A-Z])(?=.*[a-z]))^.{8,}$/',
            'retype_password' => 'required|same:password',
        ],
        [
            'name.required' => 'Please enter your name',
            'phone.required' => 'Please enter your address',
            'email.required' => 'Please enter your email',
            'dob'=>'Please enter your date of birth',
            'nid'=> 'Please enter you nid number',
            'email.unique' => 'This email is already registered',
            'password.required' => 'Please enter your password',
            'password.min' => 'Password must be at least 8 characters',
            'password.regex' => 'Password must contain at least one number, one uppercase and one lowercase letter',
            'retype_password.required' => 'Please retype your password',
            'retype_password.same' => 'Password does not match',
        ]);
   
        $DeliveryMan =new Deliveryman();
        $DeliveryMan->dm_name = $request->name;
        $DeliveryMan->dm_password = $request->password;
        $DeliveryMan->dm_email =$request->email;
        $DeliveryMan->dm_phone = $request->phone;
        $DeliveryMan->dm_nid = $request->nid;
        $DeliveryMan->dm_dob = $request->dob;
        $DeliveryMan->dm_gender =$request->gender;
        $DeliveryMan->dm_rating = "0";
        $DeliveryMan->dm_status = "Inactive";
        $DeliveryMan->save();
        
        session()->put('dmLogged', $DeliveryMan->dm_email );
        return redirect()->route('deliveryman.dashboard');

        
        
    }
    function dmRegisterConfirm(Request $request)
    {
       

    }
    function dmLoginSuccess()
    {
        return view('deliveryman.dashboard');
    }
}
