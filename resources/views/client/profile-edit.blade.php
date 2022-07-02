@extends('layouts.app')
@section('content')
    <div>
        <h1 class="m-5 text-center">Edit Profile</h1>
        <div class="container">
            <div class="main-body">
                <div class="row mb-5">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center text-center">
                                    @if(!empty($client->profile_picture))
                                        <img src="{{asset('storage/profile_pictures/'.$client->profile_picture)}}" alt="client-image" class="img-fluid rounded-circle" style="width: 200px; height: 200px;">
                                    @else
                                        <img src="{{asset('storage/profile_pictures/default.jpg')}}" alt="image" class="img-fluid rounded-circle" style="width: 200px; height: 200px;">
                                    @endif
                                    <div class="mt-3">
                                        <h4>{{$client->name}}</h4>
                                        <p class="text-secondary mb-1">{{$client->address}}</p>
                                        <p class="text-muted font-size-sm">Member since {{$client->created_at}}</p>
                                        <a class="btn btn-outline-success" href={{route('client.profile.edit.picture')}}>Update Profile Picture</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 mb-5">
                        <div class="card">
                            <div class="card-body">
                                <form action="" method="POST">
                                    {{csrf_field()}}
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Name</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" name="name" class="form-control" value="{{$client->name}}">
                                        @error('name')
                                            <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                    
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Email</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" name="email" class="form-control" value="{{$client->email}}" disabled>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Address</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" name="address" class="form-control" value="{{$client->address}}">
                                        @error('address')
                                            <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="submit" class="btn btn-success px-4" value="Save Changes">
                                    </div>
                                </div>
                                </form>
                                <a class="text-success" href="{{route('client.profile.edit.password')}}">Change Password</a>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection