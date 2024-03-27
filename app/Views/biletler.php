<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        td {
            line-height: 64px;
            text-align: center;
        }
        th:not(:first-child) {
            text-align: center;
        }
    </style>
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
            <h2>Biletlerim</h2>
            <hr>
            <div class="row d-flex flex-column flex-lg-row">
                <?php
                /**
                 * @var array $biletler
                 */
                ?>

                <?php foreach ($biletler as $bilet): ?>
                    <div class="container col-lg-6 mb-4">
                        <div class="d-flex flex-row align-items-center gap-4 p-3 card shadow-sm">
                            <div class="qrcode"></div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="fw-light fs-6">Ad-Soyadı</div>
                                    <?php
                                    $soyadi = strlen($bilet['soyadi']) > 7 ? mb_substr($bilet['soyadi'], 0, 7).'...' : $bilet['soyadi'];
                                    ?>
                                    <div class="fw-semibold fs-5" title="<?= "{$bilet['ad']} {$bilet['soyadi']}" ?>"><?= "{$bilet['ad']} $soyadi" ?></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="fw-light fs-6">Sefer</div>
                                    <div class="fw-semibold fs-5"><?= $bilet['sefer'] ?></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="fw-light fs-6">Sefer Tarihi</div>
                                    <div class="fw-semibold fs-5"><?= $bilet['tarih'] ?></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="fw-light fs-6">Koltuk Numarası</div>
                                    <div class="fw-semibold fs-5"><?= $bilet['koltuk_no'] ?></div>
                                </div>
                                <div class="col-12">
                                    <div class="fw-light fs-6">Alım Tarihi</div>
                                    <div class="fw-semibold fs-5"><?= $bilet['alim_tarihi'] ?></div>
                                </div>
                                <p hidden="hidden" class="pnr"><?= $bilet['pnr'] ?></p>
                            </div>
                            <button type="button" class="btn-close" aria-label="Sil" data-bs-toggle="modal" data-bs-target="#deleteConfirm" onclick="clickedId = <?= $bilet['id'] ?>"></button>
                        </div>
                    </div>
                <?php endforeach; ?>
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

<script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>

<script>
    let clickedId = 0;

    function deleteBilet(id) {
        fetch('<?= base_url('bilet-sil') ?>/' + id, {
            method: 'DELETE',
        }).then(() => {
            location.reload();
        });
    }

    document.querySelectorAll('.qrcode').forEach(element => {
        new QRCode(element, {
            text: "<?= base_url('bilet-kontrol').'/' ?>" + element.parentElement.parentElement.querySelector('.pnr').innerText,
            width: 128,
            height: 128
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>