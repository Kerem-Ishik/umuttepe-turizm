<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ana sayfa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            display: flex;
            min-height: 100svh;
            flex-direction: column;
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        #map {
            height: 100%;
            width: 100%;
            margin-top: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 992px) {
            #map {
                height: 18rem;
            }
        }
    </style>
</head>
<body>
<?php include('header.php'); ?>

<main class="p-4 d-flex flex-fill align-items-center justify-content-center">
    <div class="container flex-column flex-lg-row d-flex">
        <div class="container">
            <div id="map"></div>
            <h4 id="distance" class="mt-3 align-self-center"></h4>
        </div>
        <div class="container">
            <form action="<?= base_url('seferAra') ?>" method="post">
                <div class="mb-3">
                    <label for="origin">Nereden</label>
                    <select id="origin" name="kalkis" class="form-select mb-3">
                        <option selected disabled>Seçiniz</option>
                        <option value="İstanbul">İstanbul</option>
                        <option value="Ankara">Ankara</option>
                        <option value="İzmir">İzmir</option>
                        <option value="Antalya">Antalya</option>
                    </select>
                    <span class="text-danger">
                        <?php if (! empty(session()->getFlashdata('validation'))) : ?>
                            <?= display_error(session()->getFlashdata('validation'), 'kalkis') ?>
                        <?php endif ?>
                    </span>
                </div>

                <div class="mb-3">
                    <label for="destination">Nereye</label>
                    <select id="destination" name="varis" class="form-select">
                        <option selected disabled>Seçiniz</option>
                    </select>
                    <span class="text-danger">
                        <?php if (! empty(session()->getFlashdata('validation'))) : ?>
                            <?= display_error(session()->getFlashdata('validation'), 'varis') ?>
                        <?php endif ?>
                    </span>
                </div>

                <div class="d-flex flex-row gap-3">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="gidis_tipi" value="gidis" id="gidis" checked/>
                        <label class="form-check-label" for="gidis">Gidiş</label>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="gidis_tipi" value="gidis_donus" id="gidis_donus" />
                        <label class="form-check-label" for="gidis_donus">Gidiş-Dönüş</label>
                    </div>
                </div>

                <div class="d-flex flex-row gap-2 mb-3">
                    <div class="flex-fill">
                        <label for="gidis_tarihi">Gidiş Tarihi</label>
                        <input type="date" name="gidis_tarihi" id="gidis_tarihi" class="form-control" min="<?= date('Y-m-d') ?>"/>
                        <span class="text-danger">
                            <?php if (! empty(session()->getFlashdata('validation'))) : ?>
                                <?= display_error(session()->getFlashdata('validation'), 'gidis_tarihi') ?>
                            <?php endif ?>
                        </span>
                    </div>

                    <div class="flex-fill">
                        <label for="donus_tarihi">Dönüş tarihi</label>
                        <input type="date" name="donus_tarihi" id="donus_tarihi" class="form-control" min="<?= date('Y-m-d') ?>" disabled/>
                    </div>
                </div>

                <div>
                    <span class="text-danger">
                            <?php if (! empty(session()->getFlashdata('validation'))) : ?>
                                <?= display_error(session()->getFlashdata('validation'), 'donus_tarihi') ?>
                            <?php endif ?>
                        </span>
                </div>

                <button type="submit" class="btn btn-primary">Sefer ara</button>
            </form>
        </div>
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

        /** @param {Event} event */
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

    document.getElementsByName('gidis_tipi').forEach((radio) => {
        radio.addEventListener('change', () => {
            document.getElementById('donus_tarihi').disabled = radio.value === 'gidis';
        });
    });

    window.onload = () => {
        document.querySelector('form').reset();
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAlsV41_jlFTFhzWwTLy7TpeioSuggP7Q0&libraries=places&callback=initMap" async defer></script>
</body>
</html>
