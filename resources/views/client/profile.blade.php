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
                <a class="btn btn-success w-100" href="{{route('delivery.from')}}"> Make a Delivery> </a>
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
                <a href="{{route('profile.deliveries')}}" class="btn btn-success">View Ordered Deliveries</a>
            </div>
          </div>

        </div>
    </div>

@endsection