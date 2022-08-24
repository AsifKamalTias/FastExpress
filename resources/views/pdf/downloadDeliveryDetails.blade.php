<html>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    </head>
    <body>
        <div class="d-flex justify-content-center mb-5">
            <h1 class="text-center text-success">FastExpress</h1>
        </div>
        <div class="d-flex justify-content-center mt-5">
            <ul className="list-group">
              <li className="list-group-item">Order Id : {{$delivery->id}}</li>
              <li className="list-group-item">Client Name : {{$client->name}}</li>
              <li className="list-group-item">Product Name: {{$delivery->delivery_product_name}}</li>
              <li className="list-group-item">Pickup Point: {{$delivery->delivery_source_address}}</li>
              <li className="list-group-item">Destination: {{$delivery->delivery_destination_address}}</li>
              <li className="list-group-item">Receiver's Phone: {{$delivery->delivery_contact}}</li>
              <li className="list-group-item">Cost: {{$delivery->delivery_price}}</li>
              <li className="list-group-item">Status: {{$delivery->delivery_status}}</li>
              <li className="list-group-item">Ordered At : {{$delivery->created_at}}</li>
            </ul>
          </div>
          <div class="mt-5">
            <p>Thankyou.</p>
          </div>
    </body>
</html>