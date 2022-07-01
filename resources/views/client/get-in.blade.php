@extends('layouts.app')
@section('content')
<section class="mt-5">
    <div class="container-fluid h-custom">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-md-9 col-lg-6 col-xl-5">
          <h1>Get in</h1>
          <br><br>
        </div>
        <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
          @if(Session()->has('invalid-auth'))
            <p class="text-danger">{{Session::get('invalid-auth')}}</p>
          @endif
          @if(Session()->has('password-changed'))
            <p class="text-success">{{Session::get('password-changed')}}</p>
          @endif
          <br><br>
          <form action="" method="POST">
            {{ csrf_field() }}
            <div class="form-outline mb-4">
              <label class="form-label">Email address</label>
              <input type="email" class="form-control form-control-lg" name="email"
                placeholder="Enter a valid email address" value="{{old('email')}}"/>
                @error('email')
                  <span class="input-err">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-outline mb-3">
              <label class="form-label">Password</label>
              <input type="password" class="form-control form-control-lg" name="password"
                placeholder="Enter password" />
                @error('password')
                  <span class="input-err">{{ $message }}</span>
                @enderror
            </div>
  
            <div class="d-flex justify-content-between align-items-center">
              <!-- Checkbox -->
              <!--
              <div class="form-check mb-0">
                <input class="form-check-input me-2" type="checkbox" name="remember" value="remember" checked/>
                <label class="form-check-label" for="remember">
                  Remember me
                </label>
              </div>
            -->
              <a href="{{route('get-in.forgot')}}" class="text-body">Forgot password?</a>
            </div>
  
            <div class="text-center text-lg-start mt-4 pt-2">
              <button type="submit" class="btn btn-success btn-lg"
                style="padding-left: 2.5rem; padding-right: 2.5rem;">Get in</button>
              <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="{{ route('register') }}"
                  class="link-danger">Register</a></p>
            </div>
  
          </form>

        </div>
      </div>
    </div>
    <br><br>
  </section>

@endsection