<div class="container m-5">
    <h1>Orders</h1>
<form action="" method="post">
    @if(Session::has('dmMessage'))
        <p class="alert alert-info">{{ Session::get('dmMessage') }}</p>
    @endif
    <table class="table table-striped">
    <thead>
        <tr>
        <th scope="col">Product Name</th>
        <th scope="col">Bill</th>
        <th scope="col">Sending From</th>
        <th scope="col">Recieving To</th>
        </tr>
    </thead>
    <tbody>
        @foreach($deliveries as $delivery)
        <tr>
        <td>{{$delivery->delivery_product_name}}</td>
        <td>{{$delivery->delivery_price}} ৳</td>
        <td>{{$delivery->delivery_destination_address}}</td>
        <td>{{$delivery->delivery_source_address}}</td>
        <td><a href="{{route('deliveryman.gtDeliveries.accept',['id'=>encrypt($delivery->id)])}}"> Accept</a></td>
        </tr>
        @endforeach
    </tbody>
    </table>
</form>
</div>