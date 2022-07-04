@extends('layouts.app')
@section('content')
    <div class="container m-5">
        <h1 class="text-center">Make a Delivery</h1>
        <div>
            <form action="" method="POST">
                {{csrf_field()}}
                <label for="source-address">Delivery From</label><br>
                <input type="text" placeholder="Latitude" name="delivery_from_lat" id="delivery-from-lat">
                <input type="text" placeholder="Longitude" name="delivery_from_lon" id="delivery-from-lon"><br><br>
                @error('delivery_from_lat')
                    <p class="text-danger">{{$message}}</p>
                @enderror
                <div style="height: 300px; width:400px" id="source-map"></div><br>
                <input class="btn btn-success" type="submit" value="Next">
            </form>
        </div>
    </div>
    <script>
        function initMap()
        {
            var initLat = 23.8103;
            var initLong= 90.4125;
            var map = new google.maps.Map(document.getElementById('source-map'), {
                zoom: 12,
                center: new google.maps.LatLng(initLat, initLong),
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });

            var vMarker = new google.maps.Marker({
                position: new google.maps.LatLng(initLat, initLong),
                draggable: true
            });

            google.maps.event.addListener(vMarker, 'dragend', function (evt) {
                $("#delivery-from-lat").val(evt.latLng.lat().toFixed(6));
                $("#delivery-from-lon").val(evt.latLng.lng().toFixed(6));
                map.panTo(evt.latLng);
            });

            map.setCenter(vMarker.position);
            vMarker.setMap(map);

        }
    </script>
    <script async src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAP_KEY')}}&callback=initMap"></script>
@endsection