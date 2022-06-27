<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Client;
use App\Models\RegConfirmationCode;
use App\Mail\ClientRegistrationConfirmation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

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
        //return view('client.register-confirm')->with('name', $request->name)->with('address', $request->address)->with('email', $request->email)->with('password', $request->password);
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
            $client->password = Hash::make($req->password);
            $client->save();

            $res=RegConfirmationCode::where('email',$req->email)->delete();
            session()->forget('registrationQueue');
            session()->put('clientLogged', $client->email);
            return redirect()->route('client.profile');
        }
        else
        {
            return "Registration failed.";
        }
    }

    function clearSessions()
    {
        return session()->flush();
    }

    function test()
    {
        return Session()->get('clientLogged');
    }

    function viewProfile()
    {
        return view('client.profile');
    }

    function viewClientRegisterConfirm()
    {
        //Session()->forget('registrationQueue');
        return view('client.register-confirm');
    }

    function clientGetOut()
    {
        session()->forget('clientLogged');
        return redirect()->route('client.get-in');
    }
}
