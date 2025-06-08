<?php

    session_start();

    require_once 'includes/koneksi.php';
    require_once 'models/mahasiswa.php';

    $dataMahasiswa = getAllDataMahasiswa($conn);

    $errorValidate = $_SESSION['errorValidate'] ?? [];
    $flashMessage = $_SESSION['flashMessage'] ?? [];

    unset($_SESSION['errorValidate']);
    unset($_SESSION['flashMessage']);

   

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

<div class="information">
    <div class="show-information">
        <?php if($flashMessage) : ?>
            <p><?= $flashMessage['text']; ?></p>
        <?php endif; ?>
    </div>
</div>

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
                    <a href="views/mahasiswa/update-mahasiswa.php?id=<?= $data['id']?>"> <button class="btn btn-update-add" >Edit</button></a>
                    <form action="views/proses/proses-delete-mahasiswa.php" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');" style="display:inline;">
                         <input type="hidden" name="id_mhs" value="<?= $data['id'] ?>">
                        <button class="btn btn-delete" type="submit">Hapus</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    
    </div>

<div class="tambah-data">
    <a href="views/mahasiswa/create-mahasiswa.php">
        <button class="btn btn-update-add">
            Tambah data
        </button>
    </a>
</div>   

</body>
</html>