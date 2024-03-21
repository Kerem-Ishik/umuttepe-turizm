<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

<?php include 'header.php' ?>

<main class="d-flex flex-column align-items-center p-3">
    <ul class="nav nav-underline">
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('profile') ?>">Hesap</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="<?= base_url('profile/biletler') ?>">Biletlerim</a>
        </li>
    </ul>

    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <h2>Biletlerim</h2>
                <hr>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Ad</th>
                            <th scope="col">Soyadı</th>
                            <th scope="col">Sefer</th>
                            <th scope="col">Tarih</th>
                            <th scope="col">Koltuk</th>
                            <th scope="col">Alım Tarihi</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        /**
                         * @var array $biletler
                         */
                        ?>
                        <?php foreach ($biletler as $bilet): ?>
                            <tr>
                                <th scope="row"><?= $bilet['id'] ?></th>
                                <td><?= $bilet['ad'] ?></td>
                                <td><?= $bilet['soyadi'] ?></td>
                                <td><?= $bilet['sefer'] ?></td>
                                <td><?= $bilet['tarih'] ?></td>
                                <td><?= $bilet['koltuk_no'] ?></td>
                                <td><?= $bilet['alim_tarihi'] ?></td>
                                <td><button type="button" class="btn-close" aria-label="Sil" data-bs-toggle="modal" data-bs-target="#deleteConfirm" onclick="clickedId = <?= $bilet['id'] ?>"></button></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteConfirm" tabindex="-1" aria-labelledby="deleteConfirmLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteConfirmLabel">Emin misiniz?</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
                </div>
                <div class="modal-body">
                    <p>Biletinizi iptal etmek istediğinize emin misiniz?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                    <button type="button" class="btn btn-danger" id="deleteButton" onclick="deleteBilet(clickedId)">Sil</button>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    let clickedId = 0;

    function deleteBilet(id) {
        fetch('<?= base_url('bilet-sil') ?>/' + id, {
            method: 'DELETE',
        }).then(() => {
            location.reload();
        });
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>