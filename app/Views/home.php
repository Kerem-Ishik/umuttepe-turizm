<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= ($userInfo['ad'] ?? '') . ' ' . ($userInfo['soyadi'] ?? '') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<table class="table table-striped position-absolute top-50 start-50 translate-middle" style="max-width: 40rem;">
    <tbody>
        <tr>
            <th scope="row">TCKN</th>
            <td><?= $userInfo['kimlik_no'] ?? '' ?></td>
        </tr>
        <tr>
            <th scope="row">Ad</th>
            <td><?= $userInfo['ad'] ?? '' ?></td>
        </tr>
        <tr>
            <th scope="row">Soyadı</th>
            <td><?= $userInfo['soyadi'] ?? '' ?></td>
        </tr>
        <tr>
            <th scope="row">Telefon No</th>
            <td><?= $userInfo['telefon_no'] ?? '' ?></td>
        </tr>
        <tr>
            <th scope="row">E-posta</th>
            <td><?= $userInfo['e_posta'] ?? '' ?></td>
        </tr>
        <tr>
            <th scope="row">Şifre</th>
            <td><?= $userInfo['sifre'] ?? '' ?></td>
        </tr>
    </tbody>
</table>
</body>
</html>