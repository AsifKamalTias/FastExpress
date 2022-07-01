@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-center flex-column m-5">
    <div>
        <h1 class="text-center">Contact</h1>
    </div>
    <br>
        @if(Session()->has('success'))
            <p class="text-success">{{Session::get('success')}}</p>
        @endif
    <br>
    <div>
        <form action="" method="POST">
            {{ csrf_field() }}
            <label for="email">Name</label><br>
            <input id="email-field" class="code-input" type="text" name="name" value="" placeholder="Enter your name"><br><br>
            @error('name')
                <p class="text-danger">{{ $message }}</p>
            @enderror
            <label for="email">Email</label><br>
            <input id="email-field" class="code-input" type="text" name="email" value="" placeholder="Enter your email"><br><br>
            @error('email')
                <p class="text-danger">{{ $message }}</p>
            @enderror
            <label for="message">Message</label><br>
            <textarea id="message-field" class="code-input" name="message" value="" placeholder="Enter your message"></textarea><br><br>
            @error('message')
                <p class="text-danger">{{ $message }}</p>
            @enderror

            <button class="btn btn-success" type="submit">Send</button>
        </form>
    </div>
    <br>
</div>
@endsection