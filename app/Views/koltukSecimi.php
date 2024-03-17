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
                    <div class="d-flex flex-column gap-2">
                        <?php for ($i = 1; $i <= 10; $i++): ?>
                            <?php if (in_array($i, session()->get('gidisKoltuklar'))): ?>
                                <div class="seat alinmis"><?= $i ?></div>
                            <?php else: ?>
                                <div class="seat"><?= $i ?></div>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </div>
                    <div class="d-flex gap-2">
                        <div class="d-flex flex-column gap-2">
                            <?php for ($i = 11; $i <= 29; $i += 2): ?>
                                <?php if (in_array($i, session()->get('gidisKoltuklar'))): ?>
                                    <div class="seat alinmis"><?= $i ?></div>
                                <?php else: ?>
                                    <div class="seat"><?= $i ?></div>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </div>
                        <div class="d-flex flex-column gap-2">
                            <?php for ($i = 12; $i <= 30; $i += 2): ?>
                                <?php if (in_array($i, session()->get('gidisKoltuklar'))): ?>
                                    <div class="seat alinmis"><?= $i ?></div>
                                <?php else: ?>
                                    <div class="seat"><?= $i ?></div>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="secim h-100">

            </div>
        </div>
    </div>
</main>

<script>
    const seats = document.querySelectorAll('.seat:not(.alinmis)');

    seats.forEach(seat => {
        seat.addEventListener('click', handleSeatSelection);
    });

    function handleSeatSelection(event) {
        const selectedSeat = event.target;

        if (selectedSeat.classList.contains('bg-warning')) {
            selectedSeat.classList.remove('bg-warning');

            removeForm(event.target.textContent);
        }
        else {
            selectedSeat.classList.add('bg-warning');

            addForm(event.target.textContent);
        }
    }

    function removeForm(seatNumber) {
        const forms = document.querySelectorAll('.secim form');

        forms.forEach(form => {
            if (form.querySelector('input[name="koltuk_no"]').value === seatNumber) {
                form.remove();
            }
        });
    }

    function addForm(seatNumber) {
        const form = document.createElement('form');
        form.innerHTML = `
            <input type="hidden" name="koltuk_no" value="${seatNumber}">
            <div class="form-floating mb-3">
                <label for="ad">Ad</label>
                <input type="text" class="form-control" name="ad" placeholder="John" required>
            </div>
            <div class="form-floating">
                <label for="soyadi">Soyadı</label>
                <input type="text" class="form-control" name="soyadi" placeholder="Doe" required>
            </div>
        `;

        document.querySelector('.secim').appendChild(form);
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>