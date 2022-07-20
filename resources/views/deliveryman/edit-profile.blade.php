
<h1>Edit Profile</h1>

<form action="" method="post">
    {{csrf_field()}}
    
    <label for="">Name</label>
    <input type="text" name="name" id="name" value="{{$deliveryman->name}}">
    @error('name')
        <p class="text-danger">{{$message}}</p>
    @enderror
    <br>
    <label for="">Email</label>
    <input type="email" name="email" id="email" value="{{$deliveryman->email}}" disabled><br>
    <label for="">Phone</label>
    <input type="number" name="phone" value="{{$deliveryman->phone}}" id="phone">
    @error('phone')
        <p class="text-danger">{{$message}}</p>
    @enderror
    <br>
    <label for="">NID</label>
    <input type="number" name="nid" id="nid" value="{{$deliveryman->nid}}" >
    @error('nid')
        <p class="text-danger">{{$message}}</p>
    @enderror
    <br>
    <label for="">Date of Birth</label>
    <input type="date" name="dob" id="dob" value="{{$deliveryman->dob}}" >
    @error('dob')
        <p class="text-danger">{{$message}}</p>
    @enderror
    <br>
   
    
    <br>
    <input type="submit" value="Edit" name="btnClick">
    


</form>
