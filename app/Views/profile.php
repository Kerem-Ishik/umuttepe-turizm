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
            <a class="nav-link active" aria-current="page" href="<?= base_url('profile') ?>">Hesap</a>
        </li>
         <li class="nav-item">
             <a class="nav-link" href="<?= base_url('profile/biletler') ?>">Biletlerim</a>
         </li>
     </ul>

    <div class="container mt-5">
        <div class="row">
            <div class="col-12 col-md-6">
                <?php if (! empty(session()->getFlashdata('success'))): ?>
                    <div class="alert alert-success" role="alert">
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>
                <h2>Hesap</h2>
                <hr>
                <form action="<?= base_url('update') ?>" method="post">
                    <div class="mb-3">
                        <label for="e_posta" class="form-label">E-posta</label>
                        <input type="email" class="form-control" id="e_posta" name="e_posta" value="<?= session()->get('userInfo')['e_posta'] ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="sifre" class="form-label">Şifre</label>
                        <input type="password" class="form-control" id="sifre" name="sifre" autocomplete="new-password">

                        <?php if (! empty(session()->getFlashdata('validation'))): ?>
                            <span class="text-danger"><?= display_error(session()->getFlashdata('validation'), 'sifre') ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="sifre_tekrar" class="form-label mb-3">Şifre tekrar</label>
                        <input type="password" class="form-control" id="sifre_tekrar" name="sifre_tekrar">

                        <?php if (! empty(session()->getFlashdata('validation'))): ?>
                            <span class="text-danger"><?= display_error(session()->getFlashdata('validation'), 'sifre_tekrar') ?></span>
                        <?php endif; ?>
                    </div>
                    <button id="save" type="submit" class="btn btn-primary" disabled>Kaydet</button>
                </form>
            </div>
        </div>
    </div>
 </main>

 <script>
        const sifre = document.getElementById('sifre');
        const sifre_tekrar = document.getElementById('sifre_tekrar');

        const sifreValue = sifre.value;

        const button = document.querySelector('#save');

        sifre.addEventListener('input', (event) => {
            button.disabled = !(event.target.value !== sifreValue && sifre_tekrar.value === event.target.value);
        });

        sifre_tekrar.addEventListener('input', (event) => {
            button.disabled = !(event.target.value !== sifreValue && sifre.value === event.target.value);
        });
 </script>

 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
 </body>
 </html>