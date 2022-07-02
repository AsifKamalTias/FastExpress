@extends('layouts.app')
@section('content')
<section class="mb-5 mt-5">
    <div class="container-fluid h-custom">
      <div class="row d-flex justify-content-center align-items-center h-100">
        
        <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
  
            <div class="divider d-flex align-items-center my-4">
              <h1>Login</h1>
            </div>
            <!--form-->
            <form method="POST" action="" class="auth-form">
                {{ csrf_field() }}
                <div>
                    <label>Email</label><br>
                    <input type="text" name="email" placeholder="Enter your email"><br>
                    @error('email')
                    <span class="input-err">{{ $message }}</span>
                    @enderror
                    <br>
                </div>
               
                <div>
                    <label>Password</label><br>
                    <input type="password" name="password" placeholder="Enter password"><br>
                    @error('password')
                    <span class="input-err">{{ $message }}</span>
                    @enderror
                    <br>
                </div>
                
                <input type="submit" class="btn btn-success" value="Register">
            </form>
            <br>
          <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="{{ route('deliveryman.register') }}"
            class="link-danger">Register</a></p>
        </div>
      </div>
    </div>
  </section>

@endsection