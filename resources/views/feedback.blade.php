@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-center flex-column m-5">
    <div>
        <h1 class="text-center">Feedback</h1>
    </div>
    <br>
        @if(Session()->has('success'))
            <p class="text-success">{{Session::get('success')}}</p>
        @endif
    <br>
    <div>
        <form action="" method="POST">
            {{ csrf_field() }}
            <label for="feedback-title">Feedback Title</label><br>
            <input id="email-field" class="code-input" type="text" name="title" value="" placeholder="Title of Feedback"><br><br>
            @error('title')
                <p class="text-danger">{{ $message }}</p>
            @enderror
            <label for="message">Feedback</label><br>
            <textarea id="message-field" class="code-input" name="message" value="" placeholder="Enter your feedback"></textarea><br><br>
            @error('message')
                <p class="text-danger">{{ $message }}</p>
            @enderror

            <button class="btn btn-success" type="submit">Send</button>
        </form>
    </div>
    <br>
</div>
@endsection