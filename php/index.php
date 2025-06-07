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
    <title>Daftar Kartu Mahasiswa</title>
    <link rel="stylesheet" href="public/style/style.css">
</head>
<body>

    <div class="card-container">
        
        <?php foreach ($dataMahasiswa as $data) : ?>
            <div class="card">
                <div class="card-header">
                    <h3>Kartu Mahasiswa - INSTIKI</h3>
                </div>
                <div class="card-body">
                    <div class="data-item">
                        <label>Nama:</label>
                        <span id="nama"><?= $data['nama_mhs']; ?></span>
                    </div>
                    <div class="data-item">
                        <label>NIM:</label>
                        <span id="nim"><?= $data['nim']; ?></span>
                    </div>
                    <div class="data-item">
                        <label>ID Prodi:</label>
                        <span id="prodi"><?= $data['id_prodi']; ?></span>
                    </div>
                    <div class="data-item">
                        <label>Email:</label>
                        <span id="email"><?= $data['email']; ?></span>
                    </div>
                </div>
                <div class="card-actions">
                    <button class="btn btn-update" ><a href="views/mahasiswa/update-mahasiswa.php?id=<?= $data['id']?>">Edit</a></button>
                    <button class="btn btn-delete" ><a href="vies/mahasiswa/delete-mahasiswa.php?id=<?= $data['id']?>">Delete</a></button>
                </div>
            </div>
        <?php endforeach; ?>
    
    </div>

   

</body>
</html>