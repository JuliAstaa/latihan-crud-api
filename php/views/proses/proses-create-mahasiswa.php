<?php

    session_start();

    require_once __DIR__ .'/../../includes/validator.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST') {


        $dataForm = [
            "NIM" => $_POST['nim'] ?? null,
            "nama" => $_POST['nama'] ?? null,
            "id_prodi" => $_POST['id_prodi'] ?? null,
            "email" => $_POST['email'] ?? null
        ];

        

    }



?>