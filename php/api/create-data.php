<?php

    // header("Content-Type: application/json");
    // header("Access-Control-Allow-Origin: *");
    // header("Access-Control-Allow-Methods: POST");
    // header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Access-Control-Allow-Headers");

    require_once __DIR__.'/../includes/koneksi.php';
    require_once __DIR__.'/../models/mahasiswa.php';
    require_once __DIR__.'/../includes/validator.php';

    $respone = [
        'status' => null,
        'message' => '',
        'data' => null
    ];

    $exampleData = [
        "NIM" => '2401010011',
        "nama" => 'Yanagi',
        "id_prodi" => 1,
        "email" => 'yanagi@example.com'
    ];

    $dataMahasiwa = $exampleData;

    var_dump($dataMahasiwa);

    $validationError = validateInputDataMahasiswa($dataMahasiwa);

?>