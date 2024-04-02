<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koltuk Seçimi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .bus-layout {
            display: flex;
            flex-direction: column;
            width: min-content;
            gap: 1rem;
        }

        .seat {
            width: 3rem;
            height: 3rem;
            background-color: #66BB6A;
            text-align: center;
            line-height: 3rem;
            user-select: none;
            cursor: pointer;
            border-radius: 0.2rem;
        }

        .seat.alinmis {
            background-color: #EF5350;
            color: #fff;
            cursor: not-allowed;
        }

        .secim {
            max-height: 44rem;
            overflow-y: auto;
            overflow-x: hidden;
        }

        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
</head>
<body>
<?php include('header.php'); ?>

<main>
    <h2 class="text-center my-4">Koltuk Seçimi</h2>

    <div class="container">
        <h3>Gidiş</h3>

        <div class="d-flex flex-column flex-lg-row align-items-center align-items-lg-baseline justify-content-lg-around">
            <div class="bus-layout p-4 border border-2 border-opacity-25 border-black">
                <div class="w-100">
                    <img src="<?= base_url('assets/images/wheel.png') ?>" alt="Direksiyon" style="width: 3rem">
                </div>
                <div class="d-flex gap-5">
                    <?php
                    $gidis_koltuk_numaralari = array_column(session()->get('gidisBiletler'), 'koltuk_no');
                    $donus_koltuk_numaralari = session()->get('donusBiletler') !== null ?
                        array_column(session()->get('donusBiletler'), 'koltuk_no') : [];

                    function getCinsiyet(array $biletler, int $no): ?string
                    {
                        $key = array_search($no, array_column($biletler, 'koltuk_no'));
                        $arr = $key !== false ? $biletler[$key] : null;
                        if (isset($arr)) {
                            if ($arr) {
                                $person = base_url('assets/images/person-solid.svg');
                                $person_dress = base_url('assets/images/person-dress-solid.svg');
                                return $arr['cinsiyet'] === 'E' ?
                                    "<img src='$person' alt='erkek' width='25'>" :
                                    "<img src='$person_dress' alt='kadın' width='25'>";
                            }
                        }
                        return null;
                    }
                    ?>

                    <div class="d-flex flex-column gap-2">
                        <?php for ($i = 1; $i <= 10; $i++): ?>
                            <?php if (in_array($i, $gidis_koltuk_numaralari)): ?>
                                <div class="seat alinmis gidis"><?= getCinsiyet(session()->get('gidisBiletler'), $i) ?></div>
                            <?php else: ?>
                                <div class="seat gidis"><?= $i ?></div>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </div>
                    <div class="d-flex gap-2">
                        <div class="d-flex flex-column gap-2">
                            <?php for ($i = 11; $i <= 29; $i += 2): ?>
                                <?php if (in_array($i, $gidis_koltuk_numaralari)): ?>
                                    <div class="seat alinmis gidis"><?= getCinsiyet(session()->get('gidisBiletler'), $i) ?></div>
                                <?php else: ?>
                                    <div class="seat gidis"><?= $i ?></div>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </div>
                        <div class="d-flex flex-column gap-2">
                            <?php for ($i = 12; $i <= 30; $i += 2): ?>
                                <?php if (in_array($i, $gidis_koltuk_numaralari)): ?>
                                    <div class="seat alinmis gidis"><?= getCinsiyet(session()->get('gidisBiletler'), $i) ?></div>
                                <?php else: ?>
                                    <div class="seat gidis"><?= $i ?></div>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div id="secim-gidis" class="secim"></div>
        </div>

        <?php if (session()->get('donusBiletler') !== null): ?>
            <h3>Dönüş</h3>

            <div class="d-flex flex-column flex-lg-row align-items-center align-items-lg-baseline justify-content-lg-around">
                <div class="bus-layout p-4 border border-2 border-opacity-25 border-black">
                    <div class="w-100">
                        <img src="<?= base_url('assets/images/wheel.png') ?>" alt="Direksiyon" style="width: 3rem">
                    </div>
                    <div class="d-flex gap-5">
                        <div class="d-flex flex-column gap-2">
                            <?php for ($i = 1; $i <= 10; $i++): ?>
                                <?php if (in_array($i, $donus_koltuk_numaralari)): ?>
                                    <div class="seat alinmis donus"><?= getCinsiyet(session()->get('donusBiletler'), $i) ?></div>
                                <?php else: ?>
                                    <div class="seat donus"><?= $i ?></div>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="d-flex flex-column gap-2">
                                <?php for ($i = 11; $i <= 29; $i += 2): ?>
                                    <?php if (in_array($i, $donus_koltuk_numaralari)): ?>
                                        <div class="seat alinmis donus"><?= getCinsiyet(session()->get('donusBiletler'), $i) ?></div>
                                    <?php else: ?>
                                        <div class="seat donus"><?= $i ?></div>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </div>
                            <div class="d-flex flex-column gap-2">
                                <?php for ($i = 12; $i <= 30; $i += 2): ?>
                                    <?php if (in_array($i, $donus_koltuk_numaralari)): ?>
                                        <div class="seat alinmis donus"><?= getCinsiyet(session()->get('donusBiletler'), $i) ?></div>
                                    <?php else: ?>
                                        <div class="seat donus"><?= $i ?></div>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="secim-donus" class="secim"></div>
            </div>
        <?php endif; ?>

        <div class="d-flex justify-content-center mt-4">
            <button id="next" class="btn btn-primary">Devam</button>
        </div>
    </div>
</main>

<script>
    const gidisSeats = document.querySelectorAll('.gidis:not(.alinmis)');
    const donusSeats = document.querySelectorAll('.donus:not(.alinmis)');

    for (let i = 0; i < gidisSeats.length; i++) {
        gidisSeats[i].addEventListener('click', (event) => handleSeatSelection(event, "gidis", i));
    }

    for (let i = 0; i < donusSeats.length; i++) {
        donusSeats[i].addEventListener('click', (event) => handleSeatSelection(event, "donus", i));
    }

    function handleSeatSelection(event, type, num) {
        const selectedSeat = event.target;

        if (selectedSeat.classList.contains('bg-warning')) {
            selectedSeat.classList.remove('bg-warning');

            removeForm(event.target.textContent, type);
        }
        else {
            selectedSeat.classList.add('bg-warning');

            addForm(event.target.textContent, type, num);
        }
    }

    function removeForm(seatNumber, type) {
        const forms = document.querySelectorAll(`#secim-${type} form`);

        forms.forEach(form => {
            if (form.querySelector('input[name="koltuk_no"]').value === seatNumber) {
                form.remove();
            }
        });
    }

    function addForm(seatNumber, type, num) {
        const form = document.createElement('form');
        form.innerHTML = `
            <input type="hidden" name="koltuk_no" value="${seatNumber}">
            <h4>Koltuk No: ${seatNumber}</h4>
            <div class="col-md-6">
                <label for="ad" class="form-label">Ad</label>
                <input type="text" class="form-control" name="ad" placeholder="John" required>
            </div>
            <div class="col-md-6">
                <label for="soyadi" class="form-label">Soyadı</label>
                <input type="text" class="form-control" name="soyadi" placeholder="Doe" required>
            </div>
            <div class="col-md-6">
                <label for="dogum_tarihi" class="form-label">Doğum Tarihi</label>
                <input type="date" id="dogum_tarihi" name="dogum_tarihi" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label for="cinsiyet" class="form-label">Cinsiyet</label>
                <select class="form-select" id="cinsiyet" name="cinsiyet" required>
                    <option value="" selected disabled>Seçiniz</option>
                    <option value="Erkek">Erkek</option>
                    <option value="Kadın">Kadın</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="tarife" class="form-label">Tarife</label>
                <select class="form-select" id="tarife" name="tarife" required>
                    <option value="" selected disabled>Seçiniz</option>
                    <option value="tam">Tam</option>
                    <option value="yuzde_15">Öğrenci / 65+ yaş / Memur</option>
                    <option value="guvenlik">Güvenlik güçleri</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label kimlik ${type} s${num}">T.C Kimlik No</label>
                <input type="number" class="form-control tckn ${type} s${num}" name="kimlik_no" maxlength="11" placeholder="T.C Kimlik No" required>
                <input type="text" class="form-control pasaport ${type} s${num}" name="pasaport" maxlength="9" placeholder="Pasaport No" hidden="hidden" required>
            </div>
            <div class="col-12">
                <div class="form-check">
                  <input class="form-check-input switch ${type} s${num}" type="checkbox">
                  <label class="form-check-label">
                    T.C vatandaşı değilim
                  </label>
                </div>
            </div>
        `;

        form.style.maxWidth = '36rem';
        form.classList.add('row', 'g-3', 'p-3', 'border-bottom');

        document.querySelector(`#secim-${type}`).appendChild(form);

        document.querySelector(`.switch.${type}.s${num}`).addEventListener('change', function() {
            document.querySelector(`.tckn.${type}.s${num}`).value = '';
            document.querySelector(`.pasaport.${type}.s${num}`).value = '';

            if (this.checked) {
                document.querySelector(`.tckn.${type}.s${num}`).hidden = true;
                document.querySelector(`.pasaport.${type}.s${num}`).hidden = false;
                document.querySelector(`.kimlik.${type}.s${num}`).textContent = 'Pasaport No';
            } else {
                document.querySelector(`.tckn.${type}.s${num}`).hidden = false;
                document.querySelector(`.pasaport.${type}.s${num}`).hidden = true;
                document.querySelector(`.kimlik.${type}.s${num}`).textContent = 'T.C Kimlik No';
            }
        });
    }

    document.querySelector('#next').addEventListener('click', function() {
        const gidisForms = document.querySelectorAll('#secim-gidis form');
        const donusForms = document.querySelectorAll('#secim-donus form');

        if (gidisForms.length === 0) {
            alert('Lütfen gidiş için en az bir koltuk seçiniz.');
            return;
        }

        if (donusForms.length === 0 && donusSeats.length > 0) {
            alert('Lütfen dönüş için en az bir koltuk seçiniz.');
            return;
        }

        // Check if all forms are filled
        for (let i = 0; i < gidisForms.length; i++) {
            const form = gidisForms[i];
            const inputs = form.querySelectorAll('input[type="text"], input[type="number"], input[type="date"], select');

            const alerts = form.querySelectorAll('.text-danger');
            for (let j = 0; j < alerts.length; j++) {
                alerts[j].remove();
            }

            for (let j = 0; j < inputs.length; j++) {
                if (!inputs[j].value.trim() && inputs[j].hidden === false) {
                    const alert = document.createElement('span');

                    alert.classList.add('text-danger');

                    inputs[j].parentElement.appendChild(alert);

                    switch (inputs[j].name) {
                        case 'ad':
                            alert.textContent = 'Ad alanı boş bırakılamaz.';
                            break;
                        case 'soyadi':
                            alert.textContent = 'Soyadı alanı boş bırakılamaz.';
                            break;
                        case 'dogum_tarihi':
                            alert.textContent = 'Doğum tarihi alanı boş bırakılamaz.';
                            break;
                        case 'cinsiyet':
                            alert.textContent = 'Cinsiyet alanı boş bırakılamaz.';
                            break;
                        case 'tarife':
                            alert.textContent = 'Tarife alanı boş bırakılamaz.';
                            break;
                        case 'kimlik_no':
                            alert.textContent = 'Kimlik No alanı boş bırakılamaz.';
                            break;
                        case 'pasaport':
                            alert.textContent = 'Pasaport No alanı boş bırakılamaz.';
                            break;
                    }

                    return;
                }

                if (inputs[j].name === 'dogum_tarihi') {
                    const date = new Date(inputs[j].value);
                    const now = new Date();
                    if (date > now) {
                        const alert = document.createElement('span');
                        alert.classList.add('text-danger');
                        inputs[j].parentElement.appendChild(alert);
                        alert.textContent = 'Doğum tarihi bugünden büyük olamaz.';
                        return;
                    }
                }
            }
        }

        if (donusForms.length > 0) {
            for (let i = 0; i < donusForms.length; i++) {
                const form = donusForms[i];
                const inputs = form.querySelectorAll('input[type="text"], input[type="number"], input[type="date"], select');
                for (let j = 0; j < inputs.length; j++) {
                    if (!inputs[j].value.trim() && inputs[j].hidden === false) {
                        alert('Lütfen tüm alanları doldurunuz.');
                        return;
                    }
                }
            }
        }

        const gidisData = [];
        gidisForms.forEach(form => {
            const data = new FormData(form);
            const obj = {};
            data.forEach((value, key) => obj[key] = value);
            gidisData.push(obj);
        });

        const donusData = [];
        donusForms.forEach(form => {
            const data = new FormData(form);
            const obj = {};
            data.forEach((value, key) => obj[key] = value);
            donusData.push(obj);
        });

        const form = document.createElement('form');
        form.hidden = true;
        form.method = 'post';
        form.action = '<?= base_url('odemeAl') ?>';
        form.appendChild(document.createElement('input'));
        form.lastChild.name = 'gidis';
        form.lastChild.value = JSON.stringify(gidisData);

        form.appendChild(document.createElement('input'));
        form.lastChild.name = 'donus';
        form.lastChild.value = JSON.stringify(donusData);

        document.body.appendChild(form);
        form.submit();
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>