@extends('layouts.app')
@section('content')
    <div class="container m-5">
        <h1 class="text-center">Make a Delivery</h1>
        <div>
            <div class="container mt-5">
                <form action="" class="mb-5">
                    <input type="text" id="search-map">
                </form>
                <div id="map"></div>
            </div>
          
            <script type="text/javascript">
                function initMap() {
                  const initLatLng = { lat: 23.822073, lng: 90.427565 };
                  const map = new google.maps.Map(document.getElementById("map"), {
                    zoom: 12,
                    center: initLatLng,
                  });

                  let marker = new google.maps.Marker({
                    position: initLatLng,
                    map: map,
                    draggable: true,
                  });

                  new google.maps.places.Autocomplete( (document.getElementById('search-map')),{types: ['geocode']}
                );
            }

          
                window.initMap = initMap;
            </script>
          
            <script type="text/javascript"
                src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&callback=initMap" ></script>
                <script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAP_KEY')}}&libraries=places&callback=initAutocomplete"
                async defer></script>
        </div>
    </div>
@endsection