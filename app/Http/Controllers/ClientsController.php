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
use Illuminate\Support\Facades\Validator;
use App\Models\ClientToken;
use Datetime;

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
        $regConfirmationCode = RegConfirmationCode::select('code')->where('email', '=', $req->email)->orderBy('created_at', 'desc')->get();
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
    // function test()
    // {
    //     return view('deliveries.test');
    // }

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
            //$profilePictuePath = storage_path('app/')
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
            'profile_picture' => 'required|image'
        ],
        [
            'profile_picture.required' => 'Please select a image',
            'profile_picture.image' => 'Please select an image'
        ]);
        $newName = time() . '.' . $req->profile_picture->getClientOriginalExtension();
        $req->profile_picture->move(public_path('storage/profile_pictures'), $newName);

        //$req->file('profile_picture')->storeAs('public/profile_pictures',$newName);


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

    //API FUNCTIONS

    function clientRegisterResponse(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'email' => 'required|email|unique:clients',
            'password' => 'required|min:8|regex:/(?=(.*[0-9]))((?=.*[A-Za-z0-9])(?=.*[A-Z])(?=.*[a-z]))^.{8,}$/',
            'retypePassword' => 'required|same:password'
        ],
        [
            'name.required' => 'Please enter your name',
            'name.string' => 'Name must be a string',
            'name.max' => 'Name must be at most 255 characters',
            'address.required' => 'Please enter your address',
            'address.string' => 'Address must be a string',
            'address.max' => 'Address must be at most 255 characters',
            'email.required' => 'Please enter your email',
            'email.email' => 'Email must be a valid email',
            'email.unique' => 'Email already exists',
            'password.required' => 'Please enter your password',
            'password.min' => 'Password must be at least 8 characters',
            'password.regex' => 'Password must contain at least one lowercase letter, one uppercase letter and one number',
            'retypePassword.required' => 'Please confirm your password',
            'retypePassword.same' => 'Password confirmation does not match'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
        else
        {        
            $code = Str::random(6);

            $regConfirmationCode = new RegConfirmationCode();
            $regConfirmationCode->name = $request->name;
            $regConfirmationCode->address = $request->address;
            $regConfirmationCode->password = $request->password;
            $regConfirmationCode->email = $request->email;
            $regConfirmationCode->code = $code;
            $regConfirmationCode->save();

            Mail::to($request->email)->send(new ClientRegistrationConfirmation($code));

            return response()->json(['message' => 'success'], 200);
        }
        
    }

    function clientRegisterConfirmResponse(Request $req)
    {
        $regConfirmationCode = RegConfirmationCode::select('code')->where('email', '=', $req->email)->orderBy('created_at', 'desc')->get();
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
            return response()->json(['message' => 'success'], 200);
        } 
        else
        {
            // session()->flash('invalid-confirmation', 'Invalid confirmation code.');
            return response()->json(['message' => 'failed'], 422);
        }
    }

    function removeRegistrationConfirmationCode(Request $req)
    {
        $res=RegConfirmationCode::where('email',$req->email)->delete();
        return response()->json(['message' => 'success'], 200);
    }

    function getInResponse(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ],
        [
            'email.required' => 'Please enter your email',
            'email.email' => 'Email must be a valid email',
            'password.required' => 'Please enter your password'
            
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
        else
        {
            $client = Client::where('email', '=', $request->email)->get();
            if(count($client) == 0)
            {
                return response()->json(['message' => 'failed'], 422);
            }
            else
            {
                $client = $client[0];
                if($request->password == $client->password)
                {
                    $key = Str::random(32);

                    $clientToken = new ClientToken();
                    $clientToken->client_id = $client->id;
                    $clientToken->token = $key;
                    $clientToken->created_at = new DateTime();
                    $clientToken->save();
                    return response()->json(['message' => 'success', 'token' => $key], 200);
                }
                else
                {
                    return response()->json(['message' => 'Invalid username or password!'], 422);
                }
            }
        }
    }

    function profileResponse(Request $request){
        $token = $request->header('Authorization');
        $clientToken = ClientToken::where('token', '=', $token)->get();
        if(count($clientToken) == 0)
        {
            return response()->json(['message' => 'failed'], 422);
        }
        else
        {
            $client = Client::where('id', '=', $clientToken[0]->client_id)->get();
            return response()->json(['client' => $client[0]], 200);
        }
    }

    function getClientId($token){
        $result = ClientToken::where('token', '=', $token)->first();
        $client_id = $result->client_id;
        return $client_id;
    }

    function getOutResponse(Request $request)
    {
        $token = $request->header('Authorization');
        $clientToken = ClientToken::where('token', '=', $token)->get();
        if(count($clientToken) == 0)
        {
            return response()->json(['message' => 'failed'], 422);
        }
        else
        {
            $clientToken = $clientToken[0];
            $clientToken->expires_at = new DateTime();
            $clientToken->save();

            return response()->json(['message' => 'success'], 200);
        }
    }

    function editInfoResponse(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'address' => 'required|max:255'
        ],
        [
            'name.required' => 'Please enter your name',
            'name.max' => 'Name must be at most 255 characters',
            'address.required' => 'Please enter your address',
            'address.max' => 'Address must be at most 255 characters'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
        else
        {
            $token = $request->header('Authorization');
            $clientToken = ClientToken::where('token', '=', $token)->get();
            if(count($clientToken) == 0)
            {
                return response()->json(['message' => 'failed'], 422);
            }
            else
            {
                $client = Client::where('id', '=', $clientToken[0]->client_id)->get();
                $client = $client[0];
                $client->name = $request->name;
                $client->address = $request->address;
                $client->save();
                return response()->json(['message' => 'success'], 200);
            }
        }
    }

    function updateProfilePictureResponse(Request $req)
    {        
        if($req->hasfile('file')){
            $newName = time() . '.' . $req->file->getClientOriginalExtension();
            $req->file->move(public_path('storage/profile_pictures'), $newName);

            $token = $req->header('Authorization');
            $client_id = $this->getClientId($token);
            $client = Client::where('id', '=', $client_id)->get();
            $client = $client[0];
            //remove previous profile picture
            $oldName = $client->profile_picture;
            if($oldName != 'default.png')
            {
                unlink(public_path('storage/profile_pictures/' . $oldName));
            }
            $client->profile_picture = $newName;
            $client->save();
            return response()->json(['message' => 'success'], 200);
        }

        return response()->json(["msg"=>"No image selected!"], 422);
    }

    function updatePasswordResponse(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'confirmPassword' => 'required|same:password'
        ],
        [
            'password.required' => 'Please enter your password',
            'password.min' => 'Password must be at least 8 characters',
            'password.regex' => 'Password must contain at least one lowercase letter, one uppercase letter and one number',
            'confirmPassword.required' => 'Please confirm your password',
            'confirmPassword.same' => 'Password confirmation does not match'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
        else
        {
            $token = $request->header('Authorization');
            $client_id = $this->getClientId($token);
            $client = Client::where('id', '=', $client_id)->get();
            $client = $client[0];
            $client->password = $request->password;
            $client->save();
            return response()->json(['message' => 'success'], 200);
        }
    }

    function forgotPasswordEmailResponse(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ],
        [
            'email.required' => 'Please enter your email',
            'email.email' => 'Please enter a valid email'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
        else
        {
            $client = Client::where('email', '=', $request->email)->get();
            if(count($client) == 0)
            {
                return response()->json(['message' => 'failed'], 422);
            }
            else
            {
                $code = Str::random(6);
                $client = $client[0];
                $client->password_reset_code = $code;
                $client->save();
                Mail::to($request->email)->send(new ClientForgotPassword($code));
                return response()->json(['message' => 'success'], 200);
            }
        }
    }

    function forgotPasswordCodeResponse(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'code' => 'required',
            'password' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'confirmPassword' => 'required|same:password'
        ],
        [
            'email.required' => 'Please enter your email',
            'email.email' => 'Please enter a valid email',
            'code.required' => 'Please enter your code',
            'password.required' => 'Please enter your password',
            'password.min' => 'Password must be at least 8 characters',
            'password.regex' => 'Password must contain at least one lowercase letter, one uppercase letter and one number',
            'confirmPassword.required' => 'Please confirm your password',
            'confirmPassword.same' => 'Password confirmation does not match'

        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
        else
        {
            $client = Client::where('email', '=', $request->email)->get();
            if(count($client) == 0)
            {
                return response()->json(['message' => 'Failed'], 422);
            }
            else
            {
                if($client[0]->password_reset_code == $request->code)
                {
                    $client = $client[0];
                    $client->password = $request->password;
                    $client->password_reset_code = null;
                    $client->save();
                    return response()->json(['message' => 'success'], 200);
                }
                else
                {
                    return response()->json(['message' => 'Invalid Code!'], 422);
                }
            }
        }
    }

    function test(Request $request){
        $client_id = $this->getClientId($request->header("Authorization"));
        return response ()->json(['message' => 'success', 'client' => $client_id], 200);       
    }

    
}
