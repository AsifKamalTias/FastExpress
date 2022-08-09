
    <h1>{{session('dmLogged');}}</h1>
    <h3><a href="{{route('deliveryman.editProfile')}} "> Edit Profile</a> </h3>
    <h3><a href="{{route('deliveryman.changepassword');}} ">Change Pass</a></h3>
    <h3><a href="{{route('deliveryman.gtDeliveries');}} ">Get New Order</a></h3>
    <h3><a href="{{route('deliveryman.myDeliveries')}} "> Pending deliveries</a> </h3>
    
    <h3><a href="{{route('deliveryman.deliveriesCompleted')}} "> Completed deliveries</a> </h3>
    
    <h3><a href="{{route('deliveryman.logout')}} "> Logout</a> </h3>
    