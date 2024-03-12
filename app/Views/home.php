<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php /** @var array $userInfo */  ?>
    <title><?= $userInfo['ad'] . ' ' . $userInfo['soyadi'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        #navigation {
            width: 38rem;
        }

        #e_posta {
            user-select: none;
        }

        #map {
            height: 22rem;
            width: 100%;
            margin-top: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
<header>
    <nav class="navbar w-100 px-2 shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand">Umuttepe Turizm</a>

            <div class="d-flex gap-2 align-items-center">
                <span id="e_posta"><?= $userInfo['e_posta'] ?></span>
                <a role="button" href="<?= base_url('logout') ?>" class="btn btn-danger">Çıkış yap</a>
            </div>
        </div>
    </nav>
</header>

<main class="p-4">
    <div id="navigation" class="d-flex flex-column">
        <label for="origin">Nereden</label>
        <select id="origin" class="form-select mb-3">
            <option selected disabled>Seçiniz</option>
            <option value="İstanbul">İstanbul</option>
            <option value="Ankara">Ankara</option>
            <option value="İzmir">İzmir</option>
            <option value="Antalya">Antalya</option>
        </select>
        <label for="destination">Nereye</label>
        <select id="destination" class="form-select">
            <option selected disabled>Seçiniz</option>
        </select>
        <div id="map"></div>
        <h4 id="distance" class="mt-3 align-self-center"></h4>
    </div>
</main>

<script>
    function initMap() {
        const directionsService = new google.maps.DirectionsService();
        const directionsRenderer = new google.maps.DirectionsRenderer();
        const map = new google.maps.Map(document.getElementById('map'), {
            zoom: 7,
            center: {lat: 40.18, lng: 30.26},
            disableDefaultUI: true,
        });
        directionsRenderer.setMap(map);

        const originInput = document.getElementById('origin');
        const destinationInput = document.getElementById('destination');

        /** @param {InputEvent} event */
        const onOriginChange = (event) => {
            if (event.target.value === "İstanbul") {
                destinationInput.innerHTML =
                    "<option selected disabled>Seçiniz</option>" +
                    "<option value='Ankara'>Ankara</option>" +
                    "<option value='İzmir'>İzmir</option>" +
                    "<option value='Antalya'>Antalya</option>"
            } else if (event.target.value === 'Ankara') {
                destinationInput.innerHTML =
                    "<option selected disabled>Seçiniz</option>" +
                    "<option value='İstanbul'>İstanbul</option>" +
                    "<option value='İzmir'>İzmir</option>" +
                    "<option value='Antalya'>Antalya</option>"
            } else if (event.target.value === 'İzmir') {
                destinationInput.innerHTML =
                    "<option selected disabled>Seçiniz</option>" +
                    "<option value='İstanbul'>İstanbul</option>" +
                    "<option value='Ankara'>Ankara</option>" +
                    "<option value='Antalya'>Antalya</option>"
            } else if (event.target.value === 'Antalya') {
                destinationInput.innerHTML =
                    "<option selected disabled>Seçiniz</option>" +
                    "<option value='İstanbul'>İstanbul</option>" +
                    "<option value='Ankara'>Ankara</option>" +
                    "<option value='İzmir'>İzmir</option>"
            }
        };

        originInput.addEventListener('change', onOriginChange);
        destinationInput.addEventListener('change', () => calculateAndDisplayRoute(directionsService, directionsRenderer));
    }

    function calculateAndDisplayRoute(directionsService, directionsRenderer) {
        const origin = document.getElementById('origin').value;
        const destination = document.getElementById('destination').value;
        const request = {
            origin: origin,
            destination: destination,
            travelMode: 'DRIVING'
        };
        directionsService.route(request, function(result, status) {
            if (status === 'OK') {
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
