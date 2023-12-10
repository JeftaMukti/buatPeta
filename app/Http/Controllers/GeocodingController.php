<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenCage\Geocoder\Geocoder;

class GeocodingController extends Controller
{
    public function index(Request $request)
{
    if ($request->isMethod('post')) {
        // Handle POST request for geocoding

        // Get address from request
        $address = $request->input('address');

        if ($address) {
            // Geocode address
            $apiKey = 'a202888050824cf8b394fdd7e6997477';
            $geocoder = new Geocoder($apiKey);

            $result = $geocoder->geocode($address);

            if ($result['status']['message'] == 'OK') {
                $data = [
                    'address' => $address,
                    'latitude' => $result['results'][0]['geometry']['lat'],
                    'longitude' => $result['results'][0]['geometry']['lng'],
                    'formatted_address' => $result['results'][0]['formatted'],
                ];

                return view('geocoding.index', compact('data'));
            } else {
                // Handle geocoding error
                return redirect()->back()->withErrors(['message' => 'Geocoding failed.']);
            }
        } else {
            // Address is missing in POST request
            return redirect()->back()->withErrors(['message' => 'Please enter an address to geocode.']);
        }
    } else {
        // Handle GET request for displaying the form

        return view('geocoding.index');
    }
}
}
