<!DOCTYPE html>
<html lang="tr">
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
            <a class="nav-link active" href="<?= base_url('admin') ?>">Kullanıcılar</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" aria-current="page" href="<?= base_url('admin/biletler') ?>">Biletler</a>
        </li>
    </ul>

    <div class="container">
        <?php
        /**
         * @var array $users
         */
        ?>
        <h2 class="mb-5">Kullanıcılar (<?= count($users) - 1 ?>)</h2>
        <div class="d-flex flex-column flex-lg-row gap-4">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Ad</th>
                    <th scope="col">Soyadı</th>
                    <th scope="col">Kimlik</th>
                    <th scope="col">Telefon</th>
                    <th scope="col">Email</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $user): ?>
                    <?php if ($user['id'] == 1) continue; ?>
                    <tr>
                        <td><?= $user['id'] ?></td>
                        <td><?= $user['ad'] ?></td>
                        <td><?= $user['soyadi'] ?></td>
                        <td><?= $user['kimlik_no'] ?></td>
                        <td><?= $user['telefon_no'] ?></td>
                        <td><?= $user['e_posta'] ?></td>
                        <td>
                            <button type="button" class="btn-close" aria-label="Sil" data-bs-toggle="modal" data-bs-target="#deleteConfirm" onclick="clickedId = <?= $user['id'] ?>"></button></td>
                        <td>
                            <button
                                type="button"
                                class="btn d-flex align-items-center justify-content-center"
                                aria-label="Düzenle"
                                data-bs-toggle="modal"
                                data-bs-target="#editBiletForm<?=$user['id']?>"
                            >
                                <img src="<?= base_url('assets/images/pen.svg') ?>" alt="Düzenle">
                            </button>
                        </td>
                    </tr>
                    <div class="modal fade" id="editBiletForm<?=$user['id']?>" tabindex="-1" aria-labelledby="editBiletLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="editBiletLabel">Bileti Düzenle</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="editBiletForm" action="<?= base_url('user-duzenle') ?>/<?= $user['id'] ?>" method="post">
                                        <?= csrf_field() ?>

                                        <input type="hidden" id="editId" name="id">
                                        <div class="mb-3">
                                            <label for="editAd" class="form-label">Ad</label>
                                            <input type="text" class="form-control" id="editAd" name="ad" placeholder="Ad" value="<?= set_value('ad', $user['ad']) ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="editSoyadi" class="form-label">Soyad</label>
                                            <input type="text" class="form-control" id="editSoyadi" name="soyadi" placeholder="Soyadı" value="<?= set_value('soyad', $user['soyadi']) ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="editKimlik" class="form-label">Kimlik No</label>
                                            <input type="text" class="form-control" id="editKimlik" name="kimlik" placeholder="Kimlik No" value="<?= set_value('kimlik', $user['kimlik_no']) ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="editTelefon" class="form-label">Telefon</label>
                                            <input type="text" class="form-control" id="editTelefon" name="telefon" value="<?= set_value('telefon', $user['telefon_no']) ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="editEmail" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="editEmail" name="email" placeholder="Email" value="<?= set_value('email', $user['e_posta']) ?>">
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
                    <p>Bu kullanıcıyı silmek istediğinize emin misiniz?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                    <button type="button" class="btn btn-danger" id="deleteButton" onclick="deleteUser(clickedId)">Sil</button>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    let clickedId = 0;

    function deleteUser(id) {
        fetch('<?= base_url('user-sil') ?>/' + id, {
            method: 'DELETE',
        }).then(() => {
            location.reload();
        });
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
