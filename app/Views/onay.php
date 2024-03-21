<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Onay</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100svh;
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>

<main class="d-flex flex-column justify-content-center flex-fill">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center">Ödeme Başarılı</h1>
                <p class="text-center">Biletleriniz başarıyla oluşturuldu. Biletlerinizi <a href="<?= base_url('profile/biletler') ?>">profilinizden</a> görebilirsiniz.</p>
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</body>
</html>