<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OpenCage Geocoding</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <!-- Add Leaflet Routing Machine CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />

    <style>
        #map-container {
            height: 400px;
        }
    </style>
</head>
<body>
    <h1>OpenCage Geocoding Example</h1>

    @if(isset($data))
        @if(isset($data['address']))
            <h2>Geocoding results for {{ $data['address'] }}:</h2>
            <div id="map-container"></div>

            <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
            <!-- Add Leaflet Routing Machine script -->
            <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var map = L.map('map-container').setView([{{ $data['latitude'] }}, {{ $data['longitude'] }}], 15);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                    }).addTo(map);

                    L.marker([{{ $data['latitude'] }}, {{ $data['longitude'] }}]).addTo(map);

                    // Get user's IP-based location
                    fetch('https://ipapi.co/json/')
                        .then(response => response.json())
                        .then(data => {
                            var userLatitude = parseFloat(data.latitude);
                            var userLongitude = parseFloat(data.longitude);

                            L.marker([userLatitude, userLongitude]).addTo(map);

                            // Add routing between IP location and searched address
                            var control = L.Routing.control({
                                waypoints: [
                                    L.latLng(userLatitude, userLongitude), // User's IP location
                                    L.latLng({{ $data['latitude'] }}, {{ $data['longitude'] }}) // Searched address location
                                ],
                                routeWhileDragging: true
                            }).addTo(map);
                        })
                        .catch(error => console.log('Error fetching IP-based location:', error));
                });
            </script>
        @endif
    @endif

    <br>
    <form method="post" action="{{ route('geocode.index') }}">
        @csrf
        <label for="address">Enter address to geocode:</label>
        <input type="text" name="address" id="address" required>
        <button type="submit">Geocode</button>
    </form>
    
    @if($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</body>
</html>
