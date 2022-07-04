@extends('layouts.app')
@section('content')
<div class="container m-5">
    <form action="" method="POST">
        {{csrf_field()}}
        <label for="delivery_product_name">Product Name</label><br>
        <input type="text" name="delivery_product_name" placeholder="Product Name"><br>
        @error('delivery_product_name')
            <p class="text-danger">{{$message}}</p>
        @enderror
        <br>
        <label for="">Delivery From</label><br>
        <input type="text" name="delivery_from_lat" readonly placeholder="Latitude" value="{{$deliveryFromLat}}">
        <input type="text" name="delivery_from_lon" readonly placeholder="Longitude" value="{{$deliveryFromLon}}">
        <br><br>
        <label for="">Delivery To</label><br>
        <input type="text" name="delivery_to_lat" readonly placeholder="Latitude" value="{{$deliveryToLat}}">
        <input type="text" name="delivery_to_lon" readonly placeholder="Longitude" value="{{$deliveryToLon}}">
        <br><br>
        <label for="">Cost</label><br>
        <input type="text" name="delivery_price" readonly value={{$cost}}><br><br>
        <label for="">Reciever Phone Number</label><br>
        <input type="text" name="delivery_contact"><br>
        @error('delivery_contact')
            <p class="text-danger">{{$message}}</p>
        @enderror
        <br>
        <input class="btn btn-success" type="submit" value="Confirm">
    </form>
</div>
@endsection