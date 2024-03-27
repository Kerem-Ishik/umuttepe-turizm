<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bilet Kontrol</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

<main class="container mt-5">
    <?php if (isset($error)): ?>
        <div class="alert alert-danger" role="alert">
            <?= $error ?>
        </div>
    <?php else: ?>
        <?php
        /**
         * @var array $bilet
         * @var array $sefer
         */
        ?>
        <div class="alert alert-success" role="alert">
            Bilet bulundu
        </div>
        <div class="card">
            <div class="card-header">
                Bilet Detayları
            </div>
            <div class="card-body">
                <h5 class="card-title">Bilet Detayları</h5>
                <p class="card-text">PNR: <?= $bilet['pnr'] ?></p>
                <p class="card-text">Ad Soyad: <?= $bilet['ad'] . ' ' . $bilet['soyadi']?></p>
                <p class="card-text">Koltuk No: <?= $bilet['koltuk_no'] ?></p>
                <p class="card-text">Sefer: <?= $sefer['kalkis'] . '-' . $sefer['varis'] ?></p>
                <p class="card-text">Sefer Tarihi: <?= $sefer['tarih'] ?></p>
                <p class="card-text">Alım Tarihi: <?= $bilet['alim_tarihi'] ?></p>
            </div>
        </div>
    <?php endif; ?>
</main>

</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>
