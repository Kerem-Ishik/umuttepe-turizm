<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seferler</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<?php include('header.php'); ?>

<main class="p-4 d-flex flex-column gap-4 flex-fill align-items-center justify-content-center">
    <div>
        <h2 class="mb-5">Gidiş</h2>
        <div class="d-flex flex-column flex-lg-row gap-4">
            <?php foreach (session()->get('gidis_donus_data')['gidis'] as $sefer): ?>
                <div class="card p-2 shadow-sm gidis" data-id="<?= $sefer['id'] ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= $sefer['kalkis'] ?> - <?= $sefer['varis'] ?></h5>
                        <p class="card-text">Kalkış: <?= $sefer['tarih'] ?></p>
                        <p class="card-text">Doluluk: <?= $sefer['doluluk'] ?>/30</p>
                        <p class="card-text">Süre: <?= $sefer['sure'] ?> saat</p>
                        <?php
                        if ($sefer['doluluk'] === 30) {
                            echo '<button type="button" class="btn btn-primary" disabled>Seç</button>';
                        }
                        else {
                            echo '<button type="button" class="btn btn-primary">Seç</button>';
                        }
                        ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div id="gidis_alert" class="alert alert-warning mt-5" role="alert" hidden="hidden"></div>
    </div>

    <?php if (session()->get('gidis_donus_data')['donus'] !== []): ?>
        <div>
            <h2 class="mb-5">Dönüş</h2>
            <div class="d-flex flex-column flex-lg-row gap-4">
                <?php foreach (session()->get('gidis_donus_data')['donus'] as $sefer): ?>
                    <div class="card p-2 shadow-sm donus" data-id="<?= $sefer['id'] ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $sefer['kalkis'] ?> - <?= $sefer['varis'] ?></h5>
                            <p class="card-text">Kalkış: <?= $sefer['tarih'] ?></p>
                            <p class="card-text">Doluluk: <?= $sefer['doluluk'] ?>/30</p>
                            <p class="card-text">Süre: <?= $sefer['sure'] ?> saat</p>
                            <?php
                            if ($sefer['doluluk'] === 30) {
                                echo '<button type="button" class="btn btn-primary" disabled>Seç</button>';
                            }
                            else {
                                echo '<button type="button" class="btn btn-primary">Seç</button>';
                            }
                            ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div id="donus_alert" class="alert alert-warning mt-5" role="alert" hidden="hidden"></div>
        </div>
    <?php endif; ?>

    <button id="next" type="button" class="btn btn-primary mt-5">Devam</button>
</main>

<script>
    const gidisButtons = document.querySelectorAll('.gidis button');
    const donusButtons = document.querySelectorAll('.donus button');

    gidisButtons.forEach(button => {
        button.addEventListener('click', () => {
            gidisButtons.forEach(button => {
                button.removeAttribute('selected');
                button.classList.remove('btn-success');
                button.classList.add('btn-primary');
            });

            button.setAttribute('selected', '');
            button.classList.remove('btn-primary');
            button.classList.add('btn-success');
        });
    });

    donusButtons.forEach(button => {
        button.addEventListener('click', () => {
            donusButtons.forEach(button => {
                button.removeAttribute('selected');
                button.classList.remove('btn-success');
                button.classList.add('btn-primary');
            });

            button.setAttribute('selected', '');
            button.classList.remove('btn-primary');
            button.classList.add('btn-success');
        });
    });

    document.getElementById('next').addEventListener('click', () => {
        const gidis = document.querySelector('.gidis button[selected]');
        const donus = document.querySelector('.donus button[selected]');

        const gidisAlert = document.getElementById('gidis_alert');
        const donusAlert = document.getElementById('donus_alert');

        if (gidis === null) {
            gidisAlert.textContent = 'Lütfen gidiş seferi seçin.';
            gidisAlert.removeAttribute('hidden');
            return;
        }

        gidisAlert.setAttribute('hidden', '');

        if (donus === null && document.querySelector('.donus') !== null) {
            donusAlert.textContent = 'Lütfen dönüş seferi seçin.';
            donusAlert.removeAttribute('hidden');
            return;
        }

        donusAlert && donusAlert.setAttribute('hidden', '');

        const gidisId = gidis.parentElement.parentElement.getAttribute('data-id');
        const donusId = donus === null ? null : donus.parentElement.parentElement.getAttribute('data-id');

        const form = document.createElement('form');
        form.hidden = true;
        form.method = 'post';
        form.action = '<?= base_url('koltukSecimi') ?>';
        form.appendChild(document.createElement('input'));
        form.lastChild.name = 'gidis_seferi';
        form.lastChild.value = gidisId;

        if (donusId !== null) {
            form.appendChild(document.createElement('input'));
            form.lastChild.name = 'donus_seferi';
            form.lastChild.value = donusId;
        }

        document.body.appendChild(form);
        form.submit();
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>