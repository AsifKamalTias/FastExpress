@extends('layouts.app')
@section('content')
<div class="container my-5">
    <div class="row p-4 pb-0 pe-lg-0 pt-lg-5 align-items-center rounded-3 border shadow-lg">
      <div class="col-lg-7 p-3 p-lg-5 pt-lg-3">
        <h1 class="display-4 fw-bold lh-1">Send loves anytime anywhere.</h1>
        <p class="lead">#1 Parcel and Courier Service in Bangladesh. Send parcels securely & quickly.</p>
        <div class="d-grid gap-2 d-md-flex justify-content-md-start mb-4 mb-lg-3">
          @if(!Session::has('clientLogged'))
          <a type="button" href="{{route('get-in')}}" id="get-in-btn" class="btn btn-success btn-lg px-4 me-md-2 fw-bold">Get in</a>
          <a type="button" href="{{route('register')}}" id="register-btn" class="btn btn-outline-secondary btn-lg px-4">Register</a>
          @endif
        </div>
      </div>
    </div>
  </div>

  <section id="feature" class="container mt-4 mb-4">
    <div class="d-flex justify-content-center align-items-center mt-5">
      <div class="feature-item d-flex flex-column justify-content center shadow p-3 mb-5 bg-white rounded mx-2">
        <div class="icon m-auto"><i class="bi bi-truck fs-4"></i></div>
        <div class="text-center"><h6>Fast</h6></div>
      </div>
      <div class="feature-item d-flex flex-column justify-content center shadow p-3 mb-5 bg-white rounded mx-2">
        <div class="icon m-auto"><i class="bi bi-shield-lock fs-4"></i></div>
        <div class="text-center"><h6>Secure</h6></div>
      </div>
      <div class="feature-item d-flex flex-column justify-content center shadow p-3 mb-5 bg-white rounded mx-2">
        <div class="icon m-auto"><i class="bi bi-heart fs-4"></i></div>
        <div class="text-center"><h6>Trust</h6></div>
      </div>
    </div>
  </section>
  <div class="container-fluid bg-light p-4">
    <div class="container">
     <h3>Newsletter</h3>
    </div>
    <div class="d-flex justify-content-center pb-5">
     <form action="{{route('subscribe')}}" method="POST">
       {{ csrf_field() }}
       <input type="text" class="track-input" name="sub_email" placeholder="Email Address">
       <button type="submit" class="track-btn bg-success text-white border-0"><i class="bi bi-arrow-right"></i></button>
       @error('sub_email')
        <p class="text-danger">{{$message}}</p>
        @enderror
      </form>
    </div>
   </div>
@endsection