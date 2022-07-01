@extends('layouts.app')
@section('content') 
<div class="d-flex justify-content-center flex-column m-5">
    <div>
        <h1 class="text-center">Reset Password</h1>
        <p class="fw-bold">A verification code will be send to your email.</p>
    </div>
    <br><br>
        @if(Session()->has('invalid-email'))
            <p class="text-danger">{{Session::get('invalid-email')}}</p>
        @endif
    <br>
    <div>
        <form action="" method="POST">
            {{ csrf_field() }}
            <label for="email">Email</label><br>
            <input id="email-field" class="code-input" type="text" name="email" value="" placeholder="Enter your email"><br><br>
            @error('email')
                <p class="text-danger">{{$message}}</p>
            @enderror
            <button class="btn btn-success" type="submit">Send</button>
        </form>
    </div>
    <br>
</div>
@endsection