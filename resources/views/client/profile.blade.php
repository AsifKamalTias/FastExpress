@extends('layouts.app')
@section('content')
<div class="container">
    <div class="main-body mb-5 mt-5">    
          <div class="row gutters-sm">
            <div class="col-md-4 mb-3">
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
                      <a class="btn btn-success" href={{route('client.profile.edit')}}>Edit</a>
                      <a class="btn btn-outline-success" href="{{route('client.get-out')}}">Get out</a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="m-3">
                <a class="btn btn-success w-100" href="{{route('delivery.start')}}"> Make a Delivery> </a>
              </div>
            </div>
            <!--section 2-->
            <div class="col-md-8">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{session('success')}}
                    </div>
                    <br>
                @endif
                <h1>Ordered Deliveries</h1>
              <div class="card mb-3">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Full Name</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      Kenneth Valdez
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Email</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      fip@jukmuh.al
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Phone</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      (239) 816-9029
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Mobile</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      (320) 380-4539
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Address</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      Bay Area, San Francisco, CA
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-12">
                      <a class="btn btn-info " target="__blank" href="https://www.bootdey.com/snippets/view/profile-edit-data-and-skills">Edit</a>
                    </div>
                  </div>
                </div>
              </div>




            </div>
          </div>

        </div>
    </div>

@endsection