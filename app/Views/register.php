<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="vh-100">
<section class="h-100 d-flex align-items-center">
    <div class="container" >
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 col-xl-5">
                <div class="card border-0 rounded-4">
                    <div class="card-body p-3 p-md-4 p-xl-5">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-4">
                                    <h3>Kayıt ol</h3>
                                    <p>Hesabın var mı? <a href="<?= base_url('login') ?>">Giriş yap</a></p>
                                </div>
                            </div>
                        </div>
                        <form action="<?= base_url('save') ?>" method="post">
                            <?= csrf_field(); ?>
                            <?php if (! empty(session()->getFlashdata('fail'))) : ?>
                                <div class="alert alert-danger"><?= session()->getFlashdata('fail'); ?></div>
                            <?php endif ?>
                            <div class="row gy-3">
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" name="ad" id="ad" placeholder="John" value="<?= set_value('ad') ?>" autocomplete="given-name" required>
                                        <label for="ad">Ad</label>
                                        <span class="text-danger"><?= isset($validation) ? display_error($validation, 'ad') : '' ?></span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" name="soyadi" id="soyadi" placeholder="Doe" value="<?= set_value('soyadi') ?>" autocomplete="family-name" required>
                                        <label for="soyadi">Soyadı</label>
                                        <span class="text-danger"><?= isset($validation) ? display_error($validation, 'soyadi') : '' ?></span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" name="kimlik_no" id="tckn" placeholder="01234567890" value="<?= set_value('kimlik_no') ?>" autocomplete="off" required>
                                        <label for="tckn">TCKN</label>
                                        <span class="text-danger"><?= isset($validation) ? display_error($validation, 'kimlik_no') : '' ?></span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" name="e_posta" id="email" placeholder="email@example.com" value="<?= set_value('e_posta') ?>" autocomplete="email" required>
                                        <label for="email">E-Posta</label>
                                        <span class="text-danger"><?= isset($validation) ? display_error($validation, 'e_posta') : '' ?></span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" name="telefon_no" id="telefon_no" placeholder="Telefon" value="<?= set_value('telefon_no') ?>" autocomplete="tel" required>
                                        <label for="telefon_no">Telefon No</label>
                                        <span class="text-danger"><?= isset($validation) ? display_error($validation, 'telefon_no') : '' ?></span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" name="sifre" id="sifre" placeholder="Şifre" value="<?= set_value('sifre') ?>" autocomplete="password" required>
                                        <label for="sifre">Şifre</label>
                                        <span class="text-danger"><?= isset($validation) ? display_error($validation, 'sifre') : '' ?></span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" name="sifre_onayi" id="sifre_onayi" placeholder="Şifre Onayı" value="<?= set_value('sifre_onayi') ?>" autocomplete="password" required>
                                        <label for="sifre_onayi">Şifre Onayı</label>
                                        <span class="text-danger"><?= isset($validation) ? display_error($validation, 'sifre_onayi') : '' ?></span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button class="btn btn-primary" type="submit">Kayıt ol</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

</body>
</html>
