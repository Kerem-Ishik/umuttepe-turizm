
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= ($userInfo['ad'] ?? '') . ' ' . ($userInfo['soyadi'] ?? '') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        /* Custom CSS */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
        }

        table {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        th, td {
            padding: 10px;
        }

        #map {
            height: 300px;
            width: 100%;
            margin-top: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        input[type="text"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        #distance {
            margin-top: 10px;
        }
    </style>
</head>
<body>
<table class="table table-striped">
    <tbody>
        <tr>
            <th scope="row">TCKN</th>
            <td><?= $userInfo['kimlik_no'] ?? '' ?></td>
        </tr>
        <tr>
            <th scope="row">Ad</th>
            <td><?= $userInfo['ad'] ?? '' ?></td>
        </tr>
        <tr>
            <th scope="row">Soyadı</th>
            <td><?= $userInfo['soyadi'] ?? '' ?></td>
        </tr>
        <tr>
            <th scope="row">Telefon No</th>
            <td><?= $userInfo['telefon_no'] ?? '' ?></td>
        </tr>
        <tr>
            <th scope="row">E-posta</th>
            <td><?= $userInfo['e_posta'] ?? '' ?></td>
        </tr>
        <tr>
            <th scope="row">Şifre</th>
            <td><?= $userInfo['sifre'] ?? '' ?></td>
        </tr>
    </tbody>
</table>
<div>
    <label for="origin">Nereden:</label>
    <input id="origin" type="text" placeholder="İl veya İlçe adı yazın" value="Istanbul">
</div>
<div>
    <label for="destination">Nereye:</label>
    <input id="destination" type="text" placeholder="İl veya İlçe adı yazın" value="Ankara">
</div>
<div id="map"></div>
<p id="distance"></p>
<script>
    function initMap() {
        var directionsService = new google.maps.DirectionsService();
        var directionsRenderer = new google.maps.DirectionsRenderer();
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 7,
            center: {lat: 41.85, lng: -87.65}
        });
        directionsRenderer.setMap(map);

        var originInput = document.getElementById('origin');
        var destinationInput = document.getElementById('destination');
        var originAutocomplete = new google.maps.places.Autocomplete(originInput);
        var destinationAutocomplete = new google.maps.places.Autocomplete(destinationInput);

        var onChangeHandler = function() {
            calculateAndDisplayRoute(directionsService, directionsRenderer);
        };
        originInput.addEventListener('change', onChangeHandler);
        destinationInput.addEventListener('change', onChangeHandler);

        calculateAndDisplayRoute(directionsService, directionsRenderer);
    }

    function calculateAndDisplayRoute(directionsService, directionsRenderer) {
        var origin = document.getElementById('origin').value;
        var destination = document.getElementById('destination').value;
        var request = {
            origin: origin,
            destination: destination,
            travelMode: 'DRIVING'
        };
        directionsService.route(request, function(result, status) {
            if (status == 'OK') {
                directionsRenderer.setDirections(result);
                var distance = result.routes[0].legs[0].distance.text;
                document.getElementById('distance').innerHTML = 'Mesafe: ' + distance;
            } else {
                window.alert('Directions request failed due to ' + status);
            }
        });
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAlsV41_jlFTFhzWwTLy7TpeioSuggP7Q0&libraries=places&callback=initMap" async defer></script>
</body>
</html>
