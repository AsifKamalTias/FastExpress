@extends('layouts.app')
@section('content')
@php($email = "")
@if(session()->has('forgotPasswordQueue'))
    @php($email = session()->get('forgotPasswordQueue'))
@endif
<div class="d-flex justify-content-center flex-column m-5">
    <div>
        <h1 class="text-center">Reset Password</h1>
        <p>Please check your email for a confirmation code.</p>
    </div>
    <br>
        @if(Session()->has('invalid-confirmation'))
            <p class="text-danger">{{Session::get('invalid-confirmation')}}</p>
        @endif
    <br>
    <div>
        <form action="" method="POST">
            {{ csrf_field() }}
            <label for="email">Email</label><br>
            <input id="email-field" class="code-input" type="email" name="email" value="{{$email}}" placeholder="Email" readonly><br><br>
            <label for="code">Code</label><br>
            <input class="code-input" type="text" name="code" placeholder="Enter code" value="{{old('code')}}"><br><br>
            @error('code')
                <p class="text-danger">{{$message}}</p>
            @enderror
            <label for="password">New Password</label><br>
            <input class="code-input" type="password" name="password" placeholder="Enter password" value="{{old('password')}}"><br><br>
            @error('password')
                <p class="text-danger">{{$message}}</p>
            @enderror
            <label for="password_confirmation">Confirm Password</label><br>
            <input class="code-input" type="password" name="password_confirmation" placeholder="Confirm password" value="{{old('password_confirmation')}}"><br><br>
            @error('password_confirmation')
                <p class="text-danger">{{$message}}</p>
            @enderror

            <button class="btn btn-success" type="submit">Reset</button>
        </form>
    </div>
    <br>
</div>
@endsection