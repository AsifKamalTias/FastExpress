@extends('layouts.app')
@section('content')
<div class="container m-5">
    <h1>Orders</h1>
  <table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">Id</th>
      <th scope="col">Product Name</th>
      <th scope="col">Bill</th>
      <th scope="col">Sending From</th>
      <th scope="col">Recieving To</th>
      <th scope="col">Delivery Status</th>
      <!--
      <th scope="col">Deliveryman Name</th>
      <th scope="col">Deliveryman Contact</th>-->
      <th scope="col">Ordered Time</th>
    </tr>
  </thead>
  <tbody>
    @foreach($deliveries as $delivery)
    <tr>
      <th scope="row">{{$delivery->id}}</th>
      <td>{{$delivery->delivery_product_name}}</td>
      <td>{{$delivery->delivery_price}} ৳</td>
      <td>{{$delivery->delivery_destination_address}}</td>
      <td>{{$delivery->delivery_source_address}}</td>
      <td>{{$delivery->delivery_status}}</td>
      <td>{{$delivery->created_at}}</td>
    </tr>
    @endforeach
  </tbody>
</table>
</div>
@endsection