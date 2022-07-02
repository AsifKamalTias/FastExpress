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
            'phone' => 'required|min:11|numeric|unique:deliverymans',
            'email' => 'required|email|unique:deliverymans',
            'nid' => 'digits_between:10,17|required|numeric|unique:deliverymans',
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
        $DeliveryMan->name = $request->name;
        $DeliveryMan->password = $request->password;
        $DeliveryMan->email =$request->email;
        $DeliveryMan->phone = $request->phone;
        $DeliveryMan->nid = $request->nid;
        $DeliveryMan->dob = $request->dob;
        $DeliveryMan->gender =$request->gender;
        $DeliveryMan->rating = "0";
        $DeliveryMan->status = "Inactive";
        $DeliveryMan->verified= "No";
        $DeliveryMan->save();
        
        session()->put('dmLogged', $DeliveryMan->email );
        return redirect()->route('deliveryman.dashboard');

        
        
    }
    function dmLoginSuccess()
    {
        return view('deliveryman.dashboard');
    }
    function DmLoginView()
    {
        return view('deliveryman.login');
    }
    function dmLogin(Request $req)
    {
        $this->validate($req, [
            'email' => 'required|email',
            'password' => 'required'
        ],
        [
            'email.required' => 'Please enter your email',
            'email.email' => 'Please enter a valid email',
            'password.required' => 'Please enter your password'
        ]);

        $DeliveryMan = DeliveryMan::where('email', '=', $req->email)->get();
        if(count($DeliveryMan) == 0)
        {
            session()->flash('invalid-auth', 'Invalid email address!');
            return redirect()->route('get-in');
        }
        else
        {
            $DeliveryMan = $DeliveryMan[0];
            if($req->password == $DeliveryMan->password)
            {
                session()->put('dmLogged', $DeliveryMan->email);
                return redirect()->route('deliveryman.dashboard');
            }
            else
            {
                session()->flash('invalid-auth', 'Invalid password!');
                return redirect()->route('deliveryman.login');
            }

           
        }
    }
    function DmLogout()
    {
        session()->forget('dmLogged');
        return redirect()->route('deliveryman.login');
    }
}
