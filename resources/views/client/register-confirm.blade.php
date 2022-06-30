@extends('layouts.app')
@section('content')
@php($email = "")
@if(session()->has('registrationQueue'))
    @php($email = session()->get('registrationQueue'))
@endif
<div class="d-flex justify-content-center flex-column m-5">
    <div>
        <h1 class="text-center">Confirm Registration</h1>
        <p>Please check your email for a confirmation code.</p>
    </div>
    <br><br>
        @if(Session()->has('invalid-confirmation'))
            <p class="text-danger">{{Session::get('invalid-confirmation')}}</p>
        @endif
    <br><br>
    <div>
        <form action="{{route('client.register.confirm.apply')}}" method="POST">
            {{ csrf_field() }}
            <label for="email">Email</label><br>
            <input id="email-field" class="code-input" type="email" name="email" value="{{$email}}" placeholder="email" readonly><br><br>
            <label for="code">Code</label><br>
            <input class="code-input" type="text" name="code" placeholder="Enter code"><br><br>
            <button class="btn btn-success" type="submit">Confirm</button>
        </form>
    </div>
    <br>
    <a href="{{route('client.register.confirm.cancel')}}">Try with different email</a>
</div>
@endsection