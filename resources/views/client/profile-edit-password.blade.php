@extends('layouts.app')
@section('content')
    <div class="container m-5">
        <h1 class="text-center">Change Password</h1>
        <div>
            <form action="" method="POST">
                {{csrf_field()}} 
                <div class="form-group">
                    <label for="new_password">New Password</label>
                    <input type="password" name="new_password" class="form-control" id="new_password">
                    @error('new_password')
                        <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <br>
                <div class="form-group">
                    <label for="new_password_confirmation">Confirm Password</label>
                    <input type="password" name="new_password_confirmation" class="form-control" id="new_password_confirmation">
                    @error('new_password_confirmation')
                        <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <br>
                <button type="submit" class="btn btn-success">Change Password</button>
            </form>
        </div>
    </div>
@endsection