<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Price;
use App\Models\Delivery;
use App\Models\Client;

class DeliveriesController extends Controller
{
    function viewDeliveryFrom()
    {
        return view('deliveries.from');
    }

    function deliveryFromStore(Request $req)
    {
        $this->validate($req,[
            'delivery_from_lat' => 'required',
            'delivery_from_lon' => 'required'
        ],
        [
            'delivery_from_lat.required' => "Please select your location!",
            'delivery_from_lon.required' => "Please select your location!"
        ]);

        Session()->put('deliveryFromLat', $req->delivery_from_lat);
        Session()->put('deliveryFromLon', $req->delivery_from_lon);

        return redirect()->route('delivery.to');
    }

    function viewDeliveryTo()
    {
       return view('deliveries.to');
    }

    function deliveryToStore(Request $req)
    {
        $this->validate($req,[
            'delivery_to_lat' => 'required',
            'delivery_to_lon' => 'required'
        ],
        [
            'delivery_to_lat.required' => "Please select your location!",
            'delivery_to_lon.required' => "Please select your location!"
        ]);

        Session()->put('deliveryToLat', $req->delivery_to_lat);
        Session()->put('deliveryToLon', $req->delivery_to_lon);

        return redirect()->route('delivery.confirm');
    }

    function getDistanceFromLatLonInKm($lat1,$lon1,$lat2,$lon2) {
        $R = 6371; // Radius of the earth in km
        $dLat = deg2rad($lat2-$lat1);  // deg2rad below
        $dLon = deg2rad($lon2-$lon1); 
        $a = sin($dLat/2)*sin($dLat/2) +
          cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * 
          sin($dLon/2) * sin($dLon/2); 
        $c = 2 * atan2(sqrt($a), sqrt(1-$a)); 
        $d = $R * $c; // Distance in km
        return $d;
      }
      
    function deg2rad($deg) {
        return $deg * (3.1416/180);
    }

    function viewDeliveryConfirm()
    {
        $price = Price::where('price_indicator', '=', 'Price Per Kilogram')->get();
        $price = $price[0];
        $costKG = $price->price_value;
        $lat1 = (float)(session()->get('deliveryFromLat'));
        $lon1 = (float)(session()->get('deliveryFromLon'));
        $lat2 = (float)(session()->get('deliveryToLat'));
        $lon2 = (float)(session()->get('deliveryToLon'));
        $distance = $this->getDistanceFromLatLonInKm($lat1, $lon1, $lat2, $lon2);
        $cost = round($distance*$costKG);
        return view('deliveries.confirm')
            ->with('cost', $cost)
            ->with('deliveryFromLat', $lat1)
            ->with('deliveryFromLon', $lon1)
            ->with('deliveryToLat', $lat2)
            ->with('deliveryToLon', $lon2);
    }

    function deliveryConfirmApply(Request $req)
    {
        $this->validate($req, [
            'delivery_product_name' => 'required',
            'delivery_contact' => 'required',
        ],
        [
            'delivery_product_name.required' => 'Product name is required.',
            'delivery_contact.required' => 'Reciever phone number is required.'

        ]
        );

        $client = Client::where('email', '=', session()->get('clientLogged'))->get();
        $client = $client[0];
        $client_id = $client->id;

        $delivery = new Delivery();
        $delivery->delivery_product_name = $req->delivery_product_name;
        $delivery->delivery_price = $req->delivery_price;
        $delivery->delivery_source_address = $req->delivery_from_lat.', '.$req->delivery_from_lon;
        $delivery->delivery_destination_address = $req->delivery_to_lat.', '.$req->delivery_to_lon;
        $delivery->delivery_contact = $req->delivery_contact;
        $delivery->client_id = $client_id;
        $delivery->deliveryman_id = 0;
        $delivery->delivery_status = 'Pending';
        $delivery->save();

        session()->flash('success', 'New delivery order Added!');
        session()->forget('deliveryFromLat');
        session()->forget('deliveryFromLon');
        session()->forget('deliveryToLat');
        session()->forget('deliveryToLon');
        return redirect()->route('client.profile');

    }

    function showOrderedDeliveries()
    {
        $client = Client::where('email', '=', session()->get('clientLogged'))->get();
        $client = $client[0];
        $client_id = $client->id;

        $deliveries = Delivery::where('client_id', '=', $client_id)->get();
        return view('deliveries.show', compact('deliveries'));
    }
}
