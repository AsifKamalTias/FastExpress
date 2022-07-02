@extends('layouts.app')
@section('content')
    <div class="container m-5">
        <h1 class="text-center m-5">
            Update Profile Picture
        </h1>
        <form action="" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for=""><b>Upload an image</b></label><br><br>
                <input type="file" name="profile_picture" class=""><br>
                @error('profile_picture')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <br><br>
            <div class="form-group">
                <button type="submit" class="btn btn-success">Update</button>
            </div>
        </form>
    </div>
@endsection