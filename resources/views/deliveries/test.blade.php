<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Google Maps GeoCoding</title>
  </head>
  <body>
    <header>
      <h1>Reverse GeoCoding with Google Maps</h1>
    </header>
    <!-- write some stuff about a place here -->
    <script>
      const KEY = "AIzaSyBrWuHAYd1hZbgudsR8H87o9SADO3ZKgFk";
      const LAT = 50.1;
      const LNG = -97.3;
      let url = `https://maps.googleapis.com/maps/api/geocode/json?latlng=${LAT},${LNG}&key=${KEY}`;
      fetch(url)
        .then(response => response.json())
        .then(data => {
          console.log(data);
          let parts = data.results[0].address_components;
          document.body.insertAdjacentHTML(
            "beforeend",
            `<p>Formatted: ${data.results[0].formatted_address}</p>`
          );
          parts.forEach(part => {
            if (part.types.includes("country")) {
              //we found "country" inside the data.results[0].address_components[x].types array
              document.body.insertAdjacentHTML(
                "beforeend",
                `<p>COUNTRY: ${part.long_name}</p>`
              );
            }
            if (part.types.includes("administrative_area_level_1")) {
              document.body.insertAdjacentHTML(
                "beforeend",
                `<p>PROVINCE: ${part.long_name}</p>`
              );
            }
            if (part.types.includes("administrative_area_level_3")) {
              document.body.insertAdjacentHTML(
                "beforeend",
                `<p>LEVEL 3: ${part.long_name}</p>`
              );
            }
          });
        })
        .catch(err => console.warn(err.message));
    </script>
  </body>
</html>