@extends('layouts.app')
@section('content')
<section class="mb-5 mt-5">
    <div class="container-fluid h-custom">
      <div class="row d-flex justify-content-center align-items-center h-100">
        
        <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
  
            <div class="divider d-flex align-items-center my-4">
              <h1>Registration</h1>
            </div>
            <!--form-->
            <form method="POST" action="" class="auth-form">
                {{ csrf_field() }}
                <div>
                    <label>Name</label><br>
                    <input type="text" name="name" placeholder="Enter your name"><br>
                    @error('name')
                    <span class="input-err">{{ $message }}</span>
                    @enderror
                    <br>
                </div>
                <div>
                    <label>Email</label><br>
                    <input type="text" name="email" placeholder="Enter your email"><br>
                    @error('email')
                    <span class="input-err">{{ $message }}</span>
                    @enderror
                    <br>
                </div>
                <div>
                    <label>Phone</label><br>
                    <input type="phone" name="phone" placeholder="Enter your phone"><br>
                    @error('phone')
                    <span class="input-err">{{ $message }}</span>
                    @enderror
                    <br>
                </div>
                <div>
                    <label>NID</label><br>
                    <input type="number" name="nid" placeholder="Enter your nid number"><br>
                    @error('nid')
                    <span class="input-err">{{ $message }}</span>
                    @enderror
                    <br>
                </div>
                <div>
                    <label>Date Of Birth</label><br>
                    <input type="date" name="dob" placeholder="Enter your date of Birth"><br>
                    @error('dob')
                    <span class="input-err">{{ $message }}</span>
                    @enderror
                    <br>
                </div>
                <div>  
                    <label> Gender : </label><br>  
                    <input type="radio" value="Male" name="gender" checked > Male   
                    <input type="radio" value="Female" name="gender"> Female   
                    <input type="radio" value="Other" name="gender"> Other  
                    
                </div>  
                <div>
                    <label>Password</label><br>
                    <input type="password" name="password" placeholder="Enter password"><br>
                    @error('password')
                    <span class="input-err">{{ $message }}</span>
                    @enderror
                    <br>
                </div>
                <div>
                    <label>Retype Password</label><br>
                    <input type="password" name="retype_password" placeholder="Retype password"><br>
                    @error('retype_password')
                    <span class="input-err">{{ $message }}</span>
                    @enderror
                    <br>
                </div>
                <input type="submit" class="btn btn-success" value="Register">
            </form>
            <br>
          <p class="small fw-bold mt-2 pt-1 mb-0">Already have an account? <a href="{{ route('deliveryman.login') }}"
            class="link-danger">Login</a></p>
        </div>
      </div>
    </div>
  </section>

@endsection