<div class="container m-5">
    <h1>Completed Deliveries</h1>
<form action="" method="post">
    <table class="table table-striped">
    <thead>
        <tr>
        <th scope="col">Product Name</th>
        <th scope="col">Bill</th>
        <th scope="col">Sending From</th>
        <th scope="col">Recieving To</th>
        <th scope="col">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($deliveries as $delivery)
        <tr>
        <td>{{$delivery->delivery_product_name}}</td>
        <td>{{$delivery->delivery_price}} ৳</td>
        <td>{{$delivery->delivery_destination_address}}</td>
        <td>{{$delivery->delivery_source_address}}</td>
        <td>Completed</td></tr>
    </tr>
        @endforeach
    </tbody>
    </table>
</form>
</div>