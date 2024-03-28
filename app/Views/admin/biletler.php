<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<?php include(APPPATH.'/Views/header.php'); ?>

<main class="p-4 d-flex flex-column gap-4 flex-fill align-items-center justify-content-center">
    <ul class="nav nav-underline">
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('admin') ?>">Kullanıcılar</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="<?= base_url('admin/biletler') ?>">Biletler</a>
        </li>
    </ul>

    <div class="container">
        <?php
        /**
         * @var array $biletler
         * @var array $seferler
         */
        ?>
        <h2 class="mb-5">Biletler (<?= count($biletler) ?>)</h2>
        <div class="d-flex flex-column flex-lg-row gap-4">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Sefer</th>
                    <th scope="col">Koltuk No</th>
                    <th scope="col">Alım Tarihi</th>
                    <th scope="col">Ad Soyadı</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($biletler as $bilet): ?>
                    <tr>
                        <?php $sefer = $seferler[array_search($bilet['seferId'], array_column($seferler, 'id'))]; ?>
                        <td><?= $sefer['kalkis']." - ".$sefer['varis'] ?></td>
                        <td><?= $bilet['koltuk_no'] ?></td>
                        <td><?= $bilet['alim_tarihi'] ?></td>
                        <td><?= $bilet['ad']." ".$bilet['soyadi'] ?></td>
                        <td>
                            <button type="button" class="btn-close" aria-label="Sil" data-bs-toggle="modal" data-bs-target="#deleteConfirm" onclick="clickedId = <?= $bilet['id'] ?>"></button></td>
                        <td>
                            <button
                                    type="button"
                                    class="btn d-flex align-items-center justify-content-center"
                                    aria-label="Düzenle"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editBiletForm<?=$bilet['id']?>"
                            >
                                <img src="<?= base_url('assets/images/pen.svg') ?>" alt="Düzenle">
                            </button>
                        </td>
                    </tr>
                    <div class="modal fade" id="editBiletForm<?=$bilet['id']?>" tabindex="-1" aria-labelledby="editBiletLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="editBiletLabel">Bileti Düzenle</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="editBiletForm" action="<?= base_url('bilet-duzenle') ?>/<?= $bilet['id'] ?>" method="post">
                                        <input type="hidden" id="editId" name="id">
                                        <div class="mb-3">
                                            <label for="editAd" class="form-label">Ad</label>
                                            <input type="text" class="form-control" id="editAd" name="ad" placeholder="Ad" value="<?= set_value('ad', $bilet['ad']) ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="editSoyad" class="form-label">Soyad</label>
                                            <input type="text" class="form-control" id="editSoyad" name="soyad" placeholder="Soyad" value="<?= set_value('soyad', $bilet['soyadi']) ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="editSefer" class="form-label">Sefer</label>
                                            <select class="form-select" id="editSefer" name="sefer">
                                                <?php foreach ($seferler as $sefer): ?>
                                                    <?php if ($sefer['id'] == $bilet['seferId']): ?>
                                                        <option value="<?= $sefer['id'] ?>" selected><?= $sefer['kalkis']." - ".$sefer['varis'] . '/' . $sefer['tarih'] ?></option>
                                                    <?php else: ?>
                                                        <option value="<?= $sefer['id'] ?>"><?= $sefer['kalkis']." - ".$sefer['varis'] . '/' . $sefer['tarih'] ?></option>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="editKoltuk" class="form-label">Koltuk No</label>
                                            <input type="text" class="form-control" id="editKoltuk" name="koltuk" placeholder="Koltuk No" value="<?= set_value('koltuk', $bilet['koltuk_no']) ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="editAlimTarihi" class="form-label">Alım Tarihi</label>
                                            <input type="text" class="form-control" id="editAlimTarihi" name="alim_tarihi" value="<?= set_value('alim_tarihi', $bilet['alim_tarihi']) ?>" readonly>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                                            <button type="submit" class="btn btn-primary">Kaydet</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                </tbody>
            </table>
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
                    <p>Bu bileti iptal etmek istediğinize emin misiniz?</p>
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
