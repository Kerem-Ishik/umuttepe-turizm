<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ödeme</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100svh;
        }
    </style>
</head>
<body>
<?php include('header.php'); ?>

<main class="d-flex flex-column justify-content-center flex-fill">
    <div class="container mt-3">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Ad</th>
                    <th scope="col">Soyadı</th>
                    <th scope="col">Sefer</th>
                    <th scope="col">Tarih</th>
                    <th scope="col">Koltuk No</th>
                    <th scope="col">Tarife</th>
                    <th scope="col">Ücret</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $secimler = session()->get('secimler');
                $gidisSecimler = $secimler[0];
                $donusSecimler = $secimler[1];

                $toplamUcret = 0;

                $gidisUcreti = (int)session()->get('gidisUcreti');
                $donusUcreti = (int)session()->get('donusUcreti');

                $gidisData = session()->get('gidisData');
                $gidisSefer = $gidisData['kalkis'] . '-' . $gidisData['varis'];
                $gidisTarih = $gidisData['tarih'];

                $i = 1;

                function generateResults(array $secimler, int $ucret, string $sefer, string $tarih, int $seferId): int|float
                {
                    global $i;

                    $toplamUcret = 0;

                    foreach ($secimler as $secim) {
                        $i++;
                        $biletUcreti = $ucret;

                        if ($secim->tarife == 'tam') {
                            $tarife = 'Tam';

                        } else if ($secim->tarife == 'guvenlik') {
                            $tarife = "Ücretiz";
                            $biletUcreti = 0;
                        } else {
                            $tarife = '%15 indirim';
                            $biletUcreti = $ucret * 0.75;
                        }

                        $toplamUcret += $biletUcreti;

                        echo "<tr class='bilet'>";
                            echo "<th>$i</th>";
                            echo "<td>$secim->ad</td>";
                            echo "<td>$secim->soyadi</td>";
                            echo "<td>$sefer</td>";
                            echo "<td hidden='hidden'>$seferId</td>";
                            echo "<td>$tarih</td>";
                            echo "<td>$secim->koltuk_no</td>";
                            echo "<td hidden='hidden'>$secim->cinsiyet</td>";
                            echo "<td>$tarife</td>";
                            echo "<td>$biletUcreti TL</td>";
                        echo "</tr>";
                    }

                    return $toplamUcret;
                }

                $toplamUcret += generateResults($gidisSecimler, $gidisUcreti, $gidisSefer, $gidisTarih, session()->get('gidisId'));

                if ($donusSecimler) {
                    $donusData = session()->get('donusData');
                    $donusSefer = $donusData['kalkis'] . '-' . $donusData['varis'];
                    $donusTarih = $donusData['tarih'];

                    $toplamUcret += generateResults($donusSecimler, $donusUcreti, $donusSefer, $donusTarih, session()->get('donusId'));
                }
                ?>
                <tr>
                    <td colspan="7" class="text-end">Toplam Ücret</td>
                    <td><?= $toplamUcret ?> TL</td>
                </tr>
            </tbody>
        </table>
    </div>

    <?php include('ccForm.php'); ?>

    <button type="button" id="approve" class="btn btn-primary align-self-center">Onayla</button>
</main>

<script>
    document.getElementById('approve').addEventListener('click', () => {
        const biletler = document.querySelectorAll('.bilet');

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?= base_url('odemeKontrol') ?>';
        form.hidden = true;

        form.appendChild(document.createElement('input'));
        form.lastChild.name = 'cardholder';
        form.lastChild.value = document.getElementById('cardholder').value;

        form.appendChild(document.createElement('input'));
        form.lastChild.name = 'cardnumber';
        form.lastChild.value = document.getElementById('cardnumber').value;

        form.appendChild(document.createElement('input'));
        form.lastChild.name = 'expirationdate';
        form.lastChild.value = document.getElementById('expirationdate').value;

        form.appendChild(document.createElement('input'));
        form.lastChild.name = 'securitycode';
        form.lastChild.value = document.getElementById('securitycode').value;

        form.appendChild(document.createElement('input'));
        form.lastChild.name = 'biletler';
        form.lastChild.value = JSON.stringify(Array.from(biletler).map(bilet => Array.from(bilet.children).map(td => td.innerText)));

        document.body.appendChild(form);
        form.submit();
    });
</script>
</body>
</html>