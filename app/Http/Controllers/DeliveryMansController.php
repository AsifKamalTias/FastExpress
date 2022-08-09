<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Deliveryman;
use App\Models\Delivery;
use App\Mail\DeliverymanCode;
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
        
        $DeliveryMan->earnings = 0;
        $DeliveryMan->orderCompleted = 0;
        $DeliveryMan->rating = 0.0;
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
    function ViewChangePassword()
    {
        return view('deliveryman.changepassword');
    }
    function ChangePassword(Request $req)
    {
        $this->validate($req, [
            'new_password' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'new_password_confirmation' => 'required|same:new_password'
        ],
        [
            'new_password.required' => 'Please enter your password',
            'new_password.min' => 'Password must be at least 8 characters',
            'new_password.regex' => 'Password must contain at least one lowercase letter, one uppercase letter and one number',
            'new_password_confirmation.required' => 'Please confirm your password',
            'new_password_confirmation.same' => 'Password confirmation does not match'
        ]);
        $deliveryman = Deliveryman::where('email', '=', session()->get('dmLogged'))->get();
       
        $deliveryman = $deliveryman[0];
        $deliveryman->password = $req->new_password;
        $deliveryman->save();
        Session()->flash('success', 'Password updated successfully!');
        return redirect()->route('deliveryman.password.changed');
     
    }
    function ViewPasswordChanged()
    {
        return view("deliveryman.password-changed");

    }
    function ViewForgotPass()
    {
        return view('deliveryman.forgot-password');
    }
    function ForgotPass(Request $req)
    {
        $this->validate($req, [
            'email' => 'required|email'
        ],
        [
            'email.required' => 'Please enter your email',
            'email.email' => 'Please enter a valid email'
        ]);

        $deliveryman = Deliveryman::where('email', '=', $req->email)->get();
        if(count($deliveryman) == 0)
        {
            session()->flash('dm-invalid-email', 'Invalid email address!');
            return redirect()->route('deliveryman.forgotpass');
        }
        else
        {
            $deliveryman=$deliveryman[0];
            $pass=$deliveryman->password;
            Mail::to($req->email)->send(new DeliverymanCode($pass));
            session()->flash('dm-invalid-email', 'Password send to your mail');
            return redirect()->route('deliveryman.forgotpass');
            
        }

    }
    function GetDeliverymanID()
    {
        $deliveryman = Deliveryman::where('email', '=', session()->get('dmLogged'))->get();
        $deliveryman=$deliveryman[0];
        return $deliveryman->id;

    }
    function GetDeliveries()
    {
        $deliveries = Delivery::where('deliveryman_id', '=', '0')->get();
       
        return view('deliveryman.get-deliveries', compact('deliveries'));
    }
    function AcceptDeliveries($id)
    {
        $id= decrypt($id);
        $deliveries = Delivery::where('id', '=', $id)->get();
        $deliveries =$deliveries[0];
        $deliveries->deliveryman_id=$this->GetDeliverymanID();
        $deliveries->save();
        session()->flash('dmMessage', 'Success!');
        return redirect()->route('deliveryman.gtDeliveries');
            

    }
    function MyDeliveries()
    {
        $deliveries = Delivery::where('deliveryman_id', '=', $this->GetDeliverymanID())
                                ->where('delivery_status', '=', 'Pending')
                                ->get();
        
        return view('deliveryman.my-deliveries', compact('deliveries'));
    }
    function CompleteDeliveries($id)
    {
        $id= decrypt($id);
        $deliveries = Delivery::where('id', '=', $id)->get();
        $deliveries =$deliveries[0];
        $deliveries->delivery_status="Complete";
        $deliveries->save();
        session()->flash('dmMessage', 'Success!');
        // $deliveryman = Deliveryman::where('email', '=', session()->get('dmLogged'))->get();
        // $deliveryman = $deliveryman[0];
        // $DeliveryMan->earnings = 1000;
        // $DeliveryMan->orderCompleted = 10;
        // $deliveryman()->save();

        return redirect()->route('deliveryman.myDeliveries');

    }
    function DeliveriesCompleted()
    {
        $deliveries = Delivery::where('deliveryman_id', '=', $this->GetDeliverymanID())
                                ->where('delivery_status', '=', 'Complete')
                                ->get();
        if(count($deliveries) == 0)
        {
            return "<h2>No Completed Deliveries to show</h2>";

        }
        return view('deliveryman.my-completed-deliveries', compact('deliveries'));

    }
    function EditProfile()
    {
        $deliveryman = Deliveryman::where('email', '=', session()->get('dmLogged'))->get();
        $deliveryman=$deliveryman[0];
        return view('deliveryman.edit-profile', compact('deliveryman'));
    }
    function EditProfileConfirm(Request $req)
    {
        $this->validate($req, [
            'name' => 'required|string|max:255',
            'phone' => 'required|min:11|numeric',
            'nid' => 'digits_between:10,17|required|numeric',
            'dob' => 'nullable|date_format:Y-m-d|before:today',

        ]);
        $deliveryman = Deliveryman::where('email', '=', session()->get('dmLogged'))->get();
        if(count($deliveryman) == 0)
        {
            return redirect()->route('deliveryman.login');
        }
        else
        {
            $deliveryman = $deliveryman[0];
            $deliveryman->name = $req->name;
            $deliveryman->nid = $req->nid;
             $deliveryman->dob = $req->dob;
            $deliveryman->phone = $req->phone;
            $deliveryman->save();
            return redirect()->route('deliveryman.dashboard');
        }

    }
}
