<?php

    session_start();

    require_once __DIR__. '/../../includes/koneksi.php';
    require_once __DIR__. '/../../models/model_prodi.php';
    require_once __DIR__. '/../../models/mahasiswa.php';
    require_once __DIR__. '/../../includes/validator.php';

    $validationError = $_SESSION['errorValidate'] ?? [];
    $flashMessage = $_SESSION['flashMessage'] ?? [];
    $detailFormErr = $_SESSION['detailFormError'] ?? [];
    $dataForm = $_SESSION['data'] ?? [];

    $dataProdi = getAllDataProdi($conn);
    $idMahasiswa = $_GET['id'] ?? 0;
  
    if($_SERVER['REQUEST_METHOD'] !== "GET"){
        header("Location: ../../index.php");
        exit;
    }

    if(!isNumeric($idMahasiswa) && $idMahasiswa <= 0){
        header("../../not_found.php");
        exit;
    }
    
    $dataMahasiswa = getDataMahasiswaByID($conn, $_GET['id']) ?? [];
    
    // if(!$dataMahasiswa){
    //     header("Location: ../../not_found.php");
    //     exit;
    // }
    


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
        
        span {
            display: block;
            width: 100%;
            padding: 8px 10px;
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
    </style>
</head>
<body>
     <div class="container">
        <h2>Input Data Mahasiswa</h2>

        <form method="post" action="../proses/proses-update-mahasiswa.php">

            <input type="hidden" name="id_mhs" id="id_mhs" value="<?= isset($dataForm['id_mhs']) ? $dataForm['id_mhs'] : $dataMahasiswa['id'] ?>">
           

            <label>NIM:</label>
            
            <span>
                <?= $dataMahasiswa['nim']; ?>
            </span>
            <?php foreach ($validationError['nim'] ?? [] as $errNim) : ?>
                <p class="error">
                    <?= $errNim; ?>
                </p>
            <?php endforeach; ?>

            <label for="nama">Nama:</label>
            <input type="text" name="nama" id="nama" value="<?= isset($dataForm['nama']) ? $dataForm['nama'] :  $dataMahasiswa['nama_mhs']?>" required>

            <?php foreach ($validationError['nama'] ?? [] as $errNama) : ?>
                <p class="error">
                    <?= $errNama; ?>
                </p>
            <?php endforeach; ?>

            <label for="id_prodi">ID Prodi:</label>
            <?php
                $selectedProdi = $dataForm['id_prodi'] ?? $dataMahasiswa['id_prodi'] ?? null;
            ?>
            <select name="id_prodi" id="id_prodi">
                <option value="">-----</option>
                <?php foreach ($dataProdi as $i => $prodi) : ?>
                    <option value="<?= $prodi['id'] ?>" <?= ($selectedProdi == $prodi['id']) ? 'selected' : ''?>><?= $prodi['kode_prodi']; ?>--<?= $prodi['prodi']; ?></option>
                <?php endforeach; ?>
            </select>
            <?php foreach ($validationError['id_prodi'] ?? [] as $errIdProdi) : ?>
                <p class="error">
                    <?= $errIdProdi; ?>
                </p>
            <?php endforeach; ?>
            
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?= isset($dataForm['email']) ? $dataForm['email'] :  $dataMahasiswa['email'] ?>" required>
            <?php foreach ($validationError['email'] ?? [] as $errEmail) : ?>
                <p class="error">
                    <?= $errEmail; ?>
                </p>
            <?php endforeach; ?>
            
            <button value="update_mahasiswa" type="submit">Simpan</button>
        </form>
    </div>
</body>
</html>