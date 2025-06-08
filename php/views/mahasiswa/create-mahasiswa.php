<?php

    session_start();

    require_once __DIR__. '/../../includes/koneksi.php';
    require_once __DIR__. '/../../models/model_prodi.php';
    require_once __DIR__. '/../../includes/validator.php';

    $dataProdi = getAllDataProdi($conn);

    $validationError = $_SESSION['errorValidate'] ?? [];
    $flashMessage = $_SESSION['flashMessage'] ?? [];
    $detailFormErr = $_SESSION['detailFormError'] ?? [];
    $dataForm = $_SESSION['data'] ?? [];

    // var_dump($detailFormErr);
    // echo "<br>";
    // var_dump($validationError);



    unset($_SESSION['errorValidate']);
    unset($_SESSION['data']);
    unset($_SESSION['flashMessage']);
    unset($_SESSION['detailFormError']);
     

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
            margin-top: 0px;
            margin-left: 3px;
            color: red;
        }

        .button-to-back {
            position: fixed;
            bottom: 2%;
            left: 2%;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            color: white;
            transition: background-color 0.2s ease, transform 0.2s ease;
       
        }

        .btn:hover {
            transform: scale(1.05);
        }

        .btn-back {
            background-color: #dc3545;
        }

        .btn-back:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
     <div class="container">
        <h2>Input Data Mahasiswa</h2>

        <form method="post" action="../proses/proses-create-mahasiswa.php">
            <label for="nim">NIM:</label>
            <input type="text" name="nim" id="nim" value="<?= isset($dataForm["nim"]) ? $dataForm['nim'] : '' ?>" required>
            <?php foreach ($validationError['nim'] ?? [] as $errNim) : ?>
                <p class="error">
                    <?= $errNim; ?>
                </p>
            <?php endforeach; ?>

            <label for="nama">Nama:</label>
            <input type="text" name="nama" id="nama" value="<?= isset($dataForm['nama']) ? $dataForm['nama'] : ''?>" required>

            <?php foreach ($validationError['nama'] ?? [] as $errNama) : ?>
                <p class="error">
                    <?= $errNama; ?>
                </p>
            <?php endforeach; ?>

            <label for="id_prodi">ID Prodi:</label>
            <select name="id_prodi" id="id_prodi">
                <option value="">-----</option>
                <?php foreach ($dataProdi as $i => $prodi) : ?>
                    <option value="<?= $prodi['id'] ?>" <?= (isset($dataForm['id_prodi']) && $dataForm['id_prodi'] == $prodi['id']) ? 'selected' : ''?>><?= $prodi['kode_prodi']; ?>--<?= $prodi['prodi']; ?></option>
                <?php endforeach; ?>
            </select>
            <?php foreach ($validationError['id_prodi'] ?? [] as $errIdProdi) : ?>
                <p class="error">
                    <?= $errIdProdi; ?>
                </p>
            <?php endforeach; ?>
            
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?= isset($dataForm['email']) ? $dataForm['email'] : '' ?>" required>
            <?php foreach ($validationError['email'] ?? [] as $errEmail) : ?>
                <p class="error">
                    <?= $errEmail; ?>
                </p>
            <?php endforeach; ?>
            
            <button value="submit" type="submit">Simpan</button>
        </form>
    </div>
    <div class="button-to-back">
        <a href="../../index.php">
            <button class="btn btn-back">kembali</button>
        </a>
    </div>
</body>
</html>