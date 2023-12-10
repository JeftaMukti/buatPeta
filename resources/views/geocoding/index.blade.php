<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OpenCage Geocoding</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        #map-container {
            height: 400px;
        }
    </style>
</head>
<body>
    <h1>OpenCage Geocoding Example</h1>

        <h2>Geocoding results for {{ $data['address'] }}:</h2>
        <div id="map-container"></div>

        <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var map = L.map('map-container').setView([{{ $data['latitude'] }}, {{ $data['longitude'] }}], 15);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                L.marker([{{ $data['latitude'] }}, {{ $data['longitude'] }}]).addTo(map);
            });
        </script>
        <br>
        <form method="post" action="{{ route('geocode.index') }}">
            @csrf
            <label for="address">Enter address to geocode:</label>
            <input type="text" name="address" id="address" required>
            <button type="submit">Geocode</button>
        </form>
</body>
</html>
