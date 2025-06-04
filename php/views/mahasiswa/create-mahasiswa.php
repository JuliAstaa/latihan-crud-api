<?php

    require_once __DIR__. '/../../includes/koneksi.php';
    require_once __DIR__. '/../../models/model_prodi.php';

    $dataProdi = getAllDataProdi($conn);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 40px;
        }

        .container {
            background-color: white;
            width: 400px;
            margin: auto;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 10px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
            color: #555;
        }

        input[type="text"],
        input[type="number"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 6px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 6px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        button {
            margin-top: 20px;
            width: 100%;
            background-color: #3498db;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #2980b9;
        }

        .pesan {
            margin-top: 15px;
            text-align: center;
            color: green;
        }

        .error {
            color: red;
        }
    </style>
    </style>
</head>
<body>
     <div class="container">
        <h2>Input Data Mahasiswa</h2>

        <?php if (isset($pesan)): ?>
            <div class="pesan <?= strpos($pesan, 'Gagal') !== false ? 'error' : '' ?>">
                <?= $pesan ?>
            </div>
        <?php endif; ?>

        <form method="post" action="../proses/proses-create-mahasiswa.php">
            <label for="nim">NIM:</label>
            <input type="text" name="nim" id="nim" required>

            <label for="nama">Nama:</label>
            <input type="text" name="nama" id="nama" required>

            <label for="id_prodi">ID Prodi:</label>
            <select name="id_prodi" id="id_prodi">
                <option value="">-----</option>
                <?php foreach ($dataProdi as $i => $prodi) : ?>
                    <option value="<?= $prodi['id'] ?>"><?= $prodi['kode_prodi']; ?>--<?= $prodi['prodi']; ?></option>
                <?php endforeach; ?>
            </select>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>

            <button value="submit" type="submit">Simpan</button>
        </form>
    </div>
</body>
</html>