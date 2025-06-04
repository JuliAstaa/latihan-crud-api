<?php

    require_once 'includes/koneksi.php';
    require_once 'models/mahasiswa.php';

    $dataMahasiswa = getAllDataMahasiswa($conn);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TEST</title>
</head>
<body>
    <table border="1">
        <tr>
            <th>Nama</th>
            <th>NIM</th>
            <th>Email</th>
        </tr>
        <?php foreach ($dataMahasiswa as $i => $data_mhs) : ?>
        <tr>
            <td><?= $data_mhs['nama_mhs']; ?></td>
            <td><?= $data_mhs['nim']; ?></td>
            <td><?= $data_mhs['email']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

</body>
</html>