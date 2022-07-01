@extends('layouts.app')
@section('content')
<section class="mb-5 mt-5">
    <div class="container-fluid h-custom">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-md-9 col-lg-6 col-xl-5">
          <h1>Registration</h1>
        </div>
        <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
          
            <br><br>
            <!--form-->
            <form method="POST" action="" class="auth-form">
                {{ csrf_field() }}
                <div>
                    <label for="name">Name</label><br>
                    <input type="text" name="name" placeholder="Enter your name" value="{{old('name')}}"><br>
                    @error('name')
                    <span class="input-err">{{ $message }}</span>
                    @enderror
                    <br>
                </div>
                <div>
                    <label for="name">Address</label><br>
                    <input type="text" name="address" placeholder="Enter your address" value="{{old('address')}}"><br>
                    @error('address')
                    <span class="input-err">{{ $message }}</span>
                    @enderror
                    <br>
                </div>
                <div>
                    <label for="name">Email</label><br>
                    <input type="text" name="email" placeholder="Enter your email" value="{{old('email')}}"><br>
                    @error('email')
                    <span class="input-err">{{ $message }}</span>
                    @enderror
                    <br>
                </div>
                <div>
                    <label for="name">Password</label><br>
                    <input type="password" name="password" placeholder="Enter password"><br>
                    @error('password')
                    <span class="input-err">{{ $message }}</span>
                    @enderror
                    <br>
                </div>
                <div>
                    <label for="name">Retype Password</label><br>
                    <input type="password" name="retype_password" placeholder="Retype password"><br>
                    @error('retype_password')
                    <span class="input-err">{{ $message }}</span>
                    @enderror
                    <br>
                </div>
                <input type="submit" class="btn btn-success" value="Register">
            </form>
            <br>
          <p class="small fw-bold mt-2 pt-1 mb-0">Already have an account? <a href="{{ route('get-in') }}"
            class="link-danger">Get in</a></p>
        </div>
      </div>
    </div>
  </section>

@endsection