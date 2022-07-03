<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Client;
use App\Models\RegConfirmationCode;
use App\Mail\ClientRegistrationConfirmation;
use App\Mail\ClientForgotPassword;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;

class ClientsController extends Controller
{
    
    function viewGetIn()
    {
        return view('client.get-in');
    }

    
    function viewRegister()
    {
        return view('client.register');
    }

    
    function clientRegister(Request $request)
    {
       $this->validate($request, [
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'email' => 'required|email|unique:clients',
            'password' => 'required|min:8|regex:/(?=(.*[0-9]))((?=.*[A-Za-z0-9])(?=.*[A-Z])(?=.*[a-z]))^.{8,}$/',
            'retype_password' => 'required|same:password',
        ],
        [
            'name.required' => 'Please enter your name',
            'address.required' => 'Please enter your address',
            'email.required' => 'Please enter your email',
            'email.unique' => 'This email is already registered',
            'password.required' => 'Please enter your password',
            'password.min' => 'Password must be at least 8 characters',
            'password.regex' => 'Password must contain at least one number, one uppercase and one lowercase letter',
            'retype_password.required' => 'Please retype your password',
            'retype_password.same' => 'Password does not match',
        ]);

        $code = Str::random(6);

        $regConfirmationCode = new RegConfirmationCode();
        $regConfirmationCode->name = $request->name;
        $regConfirmationCode->address = $request->address;
        $regConfirmationCode->password = $request->password;
        $regConfirmationCode->email = $request->email;
        $regConfirmationCode->code = $code;
        $regConfirmationCode->save();

        Mail::to($request->email)->send(new ClientRegistrationConfirmation($code));

        Session()->put('registrationQueue', $request->email);
        return redirect()->route('client.register.confirm');
    }

    function clientRegisterConfirm(Request $req)
    {
        $regConfirmationCode = RegConfirmationCode::select('code')->where('email', '=', $req->email)->get();
        $regConfirmationCode = $regConfirmationCode[0]->code;
        if($req->code == $regConfirmationCode)
        {
            $name = RegConfirmationCode::select('name')->where('email', '=', $req->email)->get();
            $name = $name[0]->name;
            $address = RegConfirmationCode::select('address')->where('email', '=', $req->email)->get();
            $address = $address[0]->address;
            $password = RegConfirmationCode::select('password')->where('email', '=', $req->email)->get();
            $password = $password[0]->password;

            $client = new Client();
            $client->name = $name;
            $client->address = $address;
            $client->email = $req->email;
            //$client->password = Hash::make($req->password);
            $client->password = $password;
            $client->save();

            $res=RegConfirmationCode::where('email',$req->email)->delete();
            session()->forget('registrationQueue');
            session()->put('clientLogged', $client->email);
            return redirect()->route('client.profile');
        } 
        else
        {
            session()->flash('invalid-confirmation', 'Invalid confirmation code.');
            return redirect()->route('client.register.confirm');
        }
    }

    function clientRegisterConfirmApply()
    {
        return abort(404);
    }

    function clientRegisterConfirmCancel()
    {
        $res=RegConfirmationCode::where('email',session()->get('registrationQueue'))->delete();
        session()->forget('registrationQueue');
        return redirect()->route('register');
    }

    function clientGetIn(Request $req)
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

        $client = Client::where('email', '=', $req->email)->get();
        if(count($client) == 0)
        {
            session()->flash('invalid-auth', 'Invalid email address!');
            return redirect()->route('get-in');
        }
        else
        {
            $client = $client[0];
            if($req->password == $client->password)
            {
                session()->put('clientLogged', $client->email);
                return redirect()->route('client.profile');
            }
            else
            {
                session()->flash('invalid-auth', 'Invalid password!');
                return redirect()->route('get-in');
            }

            // if(Hash::check($req->password, $client->password))
            // {
            //     session()->put('clientLogged', $client->email);
            //     return redirect()->route('client.profile');
            //     
            // }
            // else
            // {
            //     session()->flash('invalid-auth', 'Invalid password!');
            //     return redirect()->route('client.get-in');
            // }
        }
    }

    function viewForgotPassword()
    {
        return view('client.forgot-password');
    }

    function clientForgotPassword(Request $req)
    {
        $this->validate($req, [
            'email' => 'required|email'
        ],
        [
            'email.required' => 'Please enter your email',
            'email.email' => 'Please enter a valid email'
        ]);

        $client = Client::where('email', '=', $req->email)->get();
        if(count($client) == 0)
        {
            session()->flash('invalid-email', 'Invalid email address!');
            return redirect()->route('get-in.forgot');
        }
        else
        {
            $code = Str::random(6);
            $client = $client[0];
            $client->password_reset_code = $code;
            $client->save();
            Mail::to($req->email)->send(new ClientForgotPassword($code));
            Session()->put('forgotPasswordQueue', $req->email);
            return redirect()->route('get-in.forgot.client.confirm');
        }
    }

    function viewClientForgotPasswordConfirm()
    {
        return view('client.forgot-password-confirm');
    }

    function clientForgotPasswordConfirmApply(Request $req)
    {
        $this->validate($req, [
            'code' => 'required',
            'password' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'password_confirmation' => 'required|same:password'
        ],
        [
            'code.required' => 'Please enter your code',
            'password.required' => 'Please enter your password',
            'password.min' => 'Password must be at least 8 characters',
            'password.regex' => 'Password must contain at least one lowercase letter, one uppercase letter and one number',
            'password_confirmation.required' => 'Please confirm your password',
            'password_confirmation.same' => 'Password confirmation does not match'
        ]);

        $client = Client::where('email', '=', $req->email)->get();
        if(count($client) == 0)
        {
            session()->flash('invalid-confirmation', 'Invalid email address!');
            return redirect()->route('get-in.forgot.confirm');
        }
        else
        {
            $client = $client[0];
            if($req->code == $client->password_reset_code)
            {
                $client->password = $req->password;
                $client->password_reset_code = null;
                $client->save();
                session()->forget('forgotPasswordQueue');
                session()->flash('password-changed', 'Password updated successfully!');
                return redirect()->route('get-in');
            }
            else
            {
                session()->flash('invalid-confirmation', 'Invalid code!');
                return redirect()->route('get-in.forgot.client.confirm');
            }
        }
    }

    //delete
    function clearSessions()
    {
        return session()->flush();
    }

    //delete
    function test()
    {
        return view('deliveries.test');
    }

    function viewProfile()
    {
        $client = Client::where('email', '=', session()->get('clientLogged'))->get();
        if(count($client) == 0)
        {
            return redirect()->route('get-in');
        }
        else
        {
            $client = $client[0];
            return view('client.profile', compact('client'));
        }
    }

    function viewClientRegisterConfirm()
    {
        return view('client.register-confirm');
    }

    function clientGetOut()
    {
        session()->forget('clientLogged');
        return redirect()->route('get-in');
    }

    function viewProfileEdit()
    {
        $client = Client::where('email', '=', session()->get('clientLogged'))->get();
        if(count($client) == 0)
        {
            return redirect()->route('get-in');
        }
        else
        {
            $client = $client[0];
            return view('client.profile-edit', compact('client'));
        }
    }

    function viewProfileEditPicture()
    {
        $client = Client::where('email', '=', session()->get('clientLogged'))->get();
        if(count($client) == 0)
        {
            return redirect()->route('get-in');
        }
        else
        {
            $client = $client[0];
            return view('client.profile-edit-picture', compact('client'));
        }
    }

    function viewProfileEditPictureApply(Request $req)
    {
        $this->validate($req, [
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ],
        [
            'profile_picture' => 'Please select a picture',
            'profile_picture' => 'Please select an image',
            'profile_picture' => 'Image must be jpeg, png, jpg, gif, or svg',
            'profile_picture' => 'Image must be less than 2MB'
        ]);
        $newName = time() . '.' . $req->profile_picture->getClientOriginalExtension();
        //$req->profile_picture->move(public_path('images/profile_pictures'), $newName);

        $req->file('profile_picture')->storeAs('public/profile_pictures',$newName);


        $client = Client::where('email', '=', session()->get('clientLogged'))->get();
        if(count($client) == 0)
        {
            return redirect()->route('get-in');
        }
        else
        {
            $client = $client[0];
            $client->profile_picture = $newName;
            $client->save();
            return redirect()->route('client.profile');
        }
        
    }

    function profileEditApply (Request $req)
    {
        $this->validate($req, [
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);
        $client = Client::where('email', '=', session()->get('clientLogged'))->get();
        if(count($client) == 0)
        {
            return redirect()->route('get-in');
        }
        else
        {
            $client = $client[0];
            $client->name = $req->name;
            $client->address = $req->address;
            $client->save();
            return redirect()->route('client.profile');
        }
    }

    function viewProfileEditPassword()
    {
        $client = Client::where('email', '=', session()->get('clientLogged'))->get();
        if(count($client) == 0)
        {
            return redirect()->route('get-in');
        }
        else
        {
            $client = $client[0];
            return view('client.profile-edit-password', compact('client'));
        }
    }

    function profileEditPassword(Request $req)
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
        $client = Client::where('email', '=', session()->get('clientLogged'))->get();
        if(count($client) == 0)
        {
            return redirect()->route('get-in');
        }
        else
        {
            $client = $client[0];
            $client->password = $req->new_password;
            $client->save();
            Session()->flash('success', 'Password updated successfully!');
            return redirect()->route('client.profile');
        }
    }
}
