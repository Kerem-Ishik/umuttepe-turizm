<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seferler</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .navbar-brand {
            user-select: none;
            cursor: pointer;
        }

        #e_posta {
            user-select: none;
        }
    </style>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg w-100 px-2 shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= base_url('/') ?>">Umuttepe Turizm</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggleContent" aria-controls="navbarToggleContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarToggleContent">
                <div class="d-flex flex-row justify-content-center justify-content-lg-end w-100">
                    <div class="d-flex flex-column flex-lg-row gap-2 align-items-center">
                        <span id="e_posta" class="navbar-text"><?= session()->get('userInfo')['e_posta'] ?></span>
                        <a role="button" href="<?= base_url('logout') ?>" class="btn btn-danger">Çıkış yap</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>

<main class="p-4 d-flex flex-column gap-4 flex-fill align-items-center justify-content-center">
    <?php foreach (session()->get('data') as $sefer): ?>
        <div class="card p-2 shadow-sm">
            <div class="card-body">
                <h5 class="card-title"><?= $sefer['kalkis'] ?> - <?= $sefer['varis'] ?></h5>
                <p class="card-text">Kalkış: <?= $sefer['tarih'] ?></p>
                <p class="card-text">Süre: <?= $sefer['sure'] ?> saat</p>
                <a href="<?= base_url('bilet-al/' . $sefer['id']) ?>" class="btn btn-primary">Bilet al</a>
            </div>
        </div>
    <?php endforeach; ?>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>