@extends('layouts.app')
@section('content')
    <div class="container m-5">
        <h1 class="text-center">Make a Delivery</h1>
        <div>
            <form action="" method="POST">
                {{csrf_field()}}
                <label for="destination-address">Delivery To</label><br>
                <input type="text" placeholder="Latitude" name="delivery_to_lat" id="delivery-to-lat">
                <input type="text" placeholder="Longitude" name="delivery_to_lon" id="delivery-to-lon"><br><br>
                @error('delivery_to_lat')
                    <p class="text-danger">{{$message}}</p>
                @enderror
                <div style="height: 300px; width:400px" id="destination-map"></div><br>
                <input class="btn btn-success" type="submit" value="Next">
            </form>
        </div>
    </div>
    <script>
        function initMap()
        {
            var initLat = 23.8103;
            var initLong= 90.4125;
            var map = new google.maps.Map(document.getElementById('destination-map'), {
                zoom: 15,
                center: new google.maps.LatLng(initLat, initLong),
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });

            var vMarker = new google.maps.Marker({
                position: new google.maps.LatLng(initLat, initLong),
                draggable: true
            });

            google.maps.event.addListener(vMarker, 'dragend', function (evt) {
                $("#delivery-to-lat").val(evt.latLng.lat().toFixed(6));
                $("#delivery-to-lon").val(evt.latLng.lng().toFixed(6));
                map.panTo(evt.latLng);
            });

            map.setCenter(vMarker.position);
            vMarker.setMap(map);

        }
    </script>
    <script async src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAP_KEY')}}&callback=initMap"></script>
@endsection