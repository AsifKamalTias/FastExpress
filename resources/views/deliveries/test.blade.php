<html>
    <head>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA1cqhYVF91n8sZU1T9LI5npEpDAFcy9c8&callback=initMap"></script>
        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>
        <script>
           function initialize() {
            var input = document.getElementById('searchTextField');
            new google.maps.places.Autocomplete(input);
            }

            google.maps.event.addDomListener(window, 'load', initialize);
        </script>
    </head>
    <body>
        <input id="searchTextField" type="text" size="50">
    </body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 
</html>